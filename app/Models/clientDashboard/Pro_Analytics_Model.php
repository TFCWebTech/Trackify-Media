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

    public function get_media_data_by_timeframe_by_id($timeframe, $client_id, $from = null, $to = null) {
        // Base SQL query for each timeframe
        switch ($timeframe) {
            case 'daily':
                $sql = "SELECT DATE_FORMAT(nd.create_at, '%W') as label, COUNT(*) as count, md.MediaType, nd.media_type_id, nd.publication_id, nd.sizeofArticle
                        FROM news_details as nd
                        JOIN mediatype as md ON md.gidMediaType = nd.media_type_id
                        WHERE FIND_IN_SET(?, nd.company) > 0";
                if ($from && $to) {
                    $sql .= " AND DATE(nd.create_at) BETWEEN ? AND ?";
                } else {
                    $sql .= " AND DATE(nd.create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
                }
                $sql .= " GROUP BY label, md.MediaType
                        ORDER BY nd.create_at";
                break;

            case 'weekly':
                $sql = "SELECT CONCAT('Week ', WEEK(nd.create_at)) as label, COUNT(*) as count, md.MediaType, nd.media_type_id, nd.publication_id, nd.sizeofArticle
                        FROM news_details as nd
                        JOIN mediatype as md ON md.gidMediaType = nd.media_type_id
                        WHERE FIND_IN_SET(?, nd.company) > 0";
                if ($from && $to) {
                    $sql .= " AND DATE(nd.create_at) BETWEEN ? AND ?";
                } else {
                    $sql .= " AND DATE(nd.create_at) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
                }
                $sql .= " GROUP BY label, md.MediaType
                        ORDER BY nd.create_at";
                break;

            case 'monthly':
                $sql = "SELECT DATE_FORMAT(nd.create_at, '%M') as label, COUNT(*) as count, md.MediaType, nd.media_type_id, nd.publication_id, nd.sizeofArticle
                        FROM news_details as nd
                        JOIN mediatype as md ON md.gidMediaType = nd.media_type_id
                        WHERE FIND_IN_SET(?, nd.company) > 0";
                if ($from && $to) {
                    $sql .= " AND DATE(nd.create_at) BETWEEN ? AND ?";
                } else {
                    $sql .= " AND YEAR(nd.create_at) = YEAR(CURDATE())";
                }
                $sql .= " GROUP BY label, md.MediaType
                        ORDER BY nd.create_at";
                break;

            default:
                return [];
        }

        // Bind parameters
        $params = [$client_id];
        if ($from && $to) {
            $params[] = $from;
            $params[] = $to;
        }

        // Execute the query with bound parameters
        $query = $this->db->query($sql, $params);
        $result = $query->result_array();

        // Calculate total AVE for all news
        foreach ($result as &$value) {
            $rates_data = $this->getRates($value['media_type_id'], $value['publication_id']);
            $ave = 0;

            if (!empty($rates_data)) {
                $article_size = $value['sizeofArticle'] ?? 0;
                $rate = $rates_data['Rate'];
                $Circulation_Fig = $rates_data['Circulation_Fig'];
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
                $value['total_ave'] = $ave; // Assign AVE to each item
            } else {
                $value['total_ave'] = 0; // No rates data found
            }

            // Remove unnecessary fields from the result
            unset($value['media_type_id']);
            unset($value['publication_id']);
            unset($value['sizeofArticle']);
        }

        return $result;
    }
    
    public function getRates($gidMediaType, $gidMediaOutlet)
    {
        return DB::table('AddRate')
            ->select('Rate', 'Circulation_Fig')
            ->where('gidMediaType', $gidMediaType)
            ->where('gidMediaOutlet', $gidMediaOutlet)
            ->first(); // Returns a single object
    }
}
