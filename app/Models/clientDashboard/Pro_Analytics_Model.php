<?php

namespace App\Models\clientDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pro_Analytics_Model extends Model
{
    use HasFactory;
    public function getDataByTimeframe($timeframe, $client_id, $from = null, $to = null)
    {
        $query = DB::table('news_details')
            ->select(
                DB::raw("CASE
                            WHEN '$timeframe' = 'daily' THEN DATE_FORMAT(create_at, '%W')
                            WHEN '$timeframe' = 'weekly' THEN CONCAT('Week ', WEEK(create_at))
                            WHEN '$timeframe' = 'monthly' THEN DATE_FORMAT(create_at, '%M')
                        END as label"),
                DB::raw('COUNT(*) as count'),
                'media_type_id',
                'publication_id',
                'sizeofArticle'
            )
            ->whereRaw("FIND_IN_SET(?, company) > 0", [$client_id]);

        if ($from && $to) {
            $query->whereBetween(DB::raw('DATE(create_at)'), [$from, $to]);
        } else {
            switch ($timeframe) {
                case 'daily':
                    $query->whereRaw('DATE(create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)');
                    break;
                case 'weekly':
                    $query->whereRaw('DATE(create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)');
                    break;
                case 'monthly':
                    $query->whereYear('create_at', '=', DB::raw('YEAR(CURDATE())'));
                    break;
            }
        }

        $query->groupBy('label', 'media_type_id', 'publication_id', 'sizeofArticle')
            ->orderBy('create_at');
        $result = $query->get()->toArray();

        // Create an associative array to store summed results
        $summedData = [];

        foreach ($result as $value) {
            $label = $value->label;
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;

            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $Circulation_Fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }

            // Aggregate the data by label
            if (!isset($summedData[$label])) {
                $summedData[$label] = [
                    'label' => $label,
                    'count' => $value->count,
                    'total_ave' => $ave
                ];
            } else {
                $summedData[$label]['count'] += $value->count;
                $summedData[$label]['total_ave'] += $ave;
            }
        }

        // Convert associative array to a simple indexed array
        $finalResult = array_values($summedData);

        return $finalResult;
    }

   
    public function getRates($gidMediaType, $gidMediaOutlet)
    {
        return DB::table('AddRate')
            ->select('Rate', 'Circulation_Fig')
            ->where('gidMediaType', $gidMediaType)
            ->where('gidMediaOutlet', $gidMediaOutlet)
            ->first(); // Returns a single object
    }

    public function getPublicationDataByTimeframeById($timeframe, $clientId, $from = null, $to = null)
    {
        // Initialize query builder
        $query = DB::table('news_details as nd')
            ->join('mediaoutlet as m', 'm.gidMediaOutlet', '=', 'nd.publication_id')
            ->selectRaw('
                CASE 
                    WHEN ? = "daily" THEN DATE_FORMAT(nd.create_at, "%W")
                    WHEN ? = "weekly" THEN CONCAT("Week ", WEEK(nd.create_at))
                    WHEN ? = "monthly" THEN DATE_FORMAT(nd.create_at, "%M")
                END as label,
                COUNT(*) as count,
                m.MediaOutlet,
                nd.media_type_id,
                nd.publication_id,
                nd.sizeofArticle
            ', [$timeframe, $timeframe, $timeframe])
            ->whereRaw('FIND_IN_SET(?, nd.company) > 0', [$clientId]);

        // Apply date range filter if specified
        if ($from && $to) {
            $query->whereBetween(DB::raw('DATE(nd.create_at)'), [$from, $to]);
        } else {
            switch ($timeframe) {
                case 'daily':
                    $query->whereRaw('DATE(nd.create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)');
                    break;
                case 'weekly':
                    $query->whereRaw('DATE(nd.create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)');
                    break;
                case 'monthly':
                    $query->whereYear('nd.create_at', '=', DB::raw('YEAR(CURDATE())'));
                    break;
            }
        }

        // Include all non-aggregated columns in the GROUP BY clause
        $query->groupBy('label', 'm.MediaOutlet', 'nd.media_type_id', 'nd.publication_id', 'nd.sizeofArticle')
            ->orderBy('label'); // Changed to 'label' since 'nd.create_at' isn't aggregated

        // Get the results
        $results = $query->get();

        // Calculate total AVE for all news
        foreach ($results as &$result) {
            $ratesData = $this->getRates($result->media_type_id, $result->publication_id);
            $ave = 0;

            if (!empty($ratesData)) {
                $articleSize = $result->sizeofArticle ?? 0;
                $rate = $ratesData->Rate ?? 0;
                $circulationFig = $ratesData->Circulation_Fig ?? 0;
                $ave = 3 * $articleSize * $rate * $circulationFig;
                $result->total_ave = $ave; // Assign AVE to each item
            } else {
                $result->total_ave = 0; // No rates data found
            }

            // Remove unnecessary fields from the result
            unset($result->media_type_id);
            unset($result->publication_id);
            unset($result->sizeofArticle);
        }

        return $results;
    }
    public function getMediaDataByTimeframeById($timeframe, $clientId, $from = null, $to = null)
    {
        // Initialize query builder
        $query = DB::table('news_details as nd')
            ->join('mediatype as md', 'md.gidMediaType', '=', 'nd.media_type_id')
            ->selectRaw('
                CASE 
                    WHEN ? = "daily" THEN DATE_FORMAT(nd.create_at, "%W")
                    WHEN ? = "weekly" THEN CONCAT("Week ", WEEK(nd.create_at))
                    WHEN ? = "monthly" THEN DATE_FORMAT(nd.create_at, "%M")
                END as label,
                md.MediaType,
                COUNT(*) as count,
                SUM(nd.sizeofArticle * 3 * COALESCE(r.Rate, 0) * COALESCE(r.Circulation_Fig, 0)) as total_ave
            ', [$timeframe, $timeframe, $timeframe])
            ->leftJoin(DB::raw('(SELECT gidMediaType, gidMediaOutlet, Rate, Circulation_Fig FROM addrate) r'), function($join) {
                $join->on('r.gidMediaType', '=', 'nd.media_type_id')
                     ->on('r.gidMediaOutlet', '=', 'nd.publication_id');
            })
            ->whereRaw('FIND_IN_SET(?, nd.company) > 0', [$clientId]);
    
        // Apply date range filter if specified
        if ($from && $to) {
            $query->whereBetween(DB::raw('DATE(nd.create_at)'), [$from, $to]);
        } else {
            switch ($timeframe) {
                case 'daily':
                    $query->whereRaw('DATE(nd.create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)');
                    break;
                case 'weekly':
                    $query->whereRaw('DATE(nd.create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)');
                    break;
                case 'monthly':
                    $query->whereYear('nd.create_at', '=', DB::raw('YEAR(CURDATE())'));
                    break;
            }
        }
    
        // Group by label and MediaType, and order by label
        $query->groupBy('label', 'md.MediaType')
              ->orderBy('label');
    
        // Get the results
        $results = $query->get();
    
        return $results;
    }
}
