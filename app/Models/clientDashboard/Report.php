<?php

namespace App\Models\clientDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Report extends Model
{
    use HasFactory;
    protected $table = 'news_details'; // Ensure the correct table name
    protected $primaryKey = 'news_details_id';
    public function getClientNewsCount($timeframe, $client_id, $from = null, $to = null)
{
    $query = DB::table('news_details')->select('*');

    // Apply date range filter if provided
    // if ($from && $to) {
    //     $query->whereBetween('create_at', [$from, $to]);
    // }

    // Apply client_id filter if provided
    if (!empty($client_id)) {
        $query->whereRaw("FIND_IN_SET(?, company)", [$client_id]);
    }

    $result = $query->get();
    $total_ave = 0;
    $news_count = 0;

    foreach ($result as $value) {
        $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
        $ave = 0;

        if (!empty($rates_data)) {
            $article_size = $value->sizeofArticle ?? 0;
            $rate = $rates_data->Rate;
            $circulation_fig = $rates_data->Circulation_Fig;
            $ave = 3 * $article_size * $rate * $circulation_fig;
        }

        $total_ave += $ave;
        $news_count++;
    }

    return [
        'news_count' => $news_count,
        'total_ave' => $total_ave
    ];
}

public function getRates($gidMediaType, $gidMediaOutlet)
{
    return DB::table('addrate')
        ->select('Rate', 'Circulation_Fig')
        ->where('gidMediaType', $gidMediaType)
        ->where('gidMediaOutlet', $gidMediaOutlet)
        ->first();
}

    public function getMediaData($timeframe, $client_id, $from = null, $to = null)
    {
        $media_types = DB::table('mediatype')->get();
        $outArr = [];

        foreach ($media_types as $row) {
            $news_data = $this->getNewsDetails($row->gidMediaType, $client_id, $from, $to);

            // Convert the Collection to an array
            $news_data_array = $news_data->toArray();

            $totalAve = array_reduce($news_data_array, function($carry, $item) {
                return $carry + ($item['ave'] ?? 0);
            }, 0);

            $outArr[] = [
                'Media_name' => $row->MediaType,
                'Count' => count($news_data_array),
                'ave' => $totalAve,
                'Client_name' => session('client_name')
            ];

            $comp_data = $this->getCompDataM('daily', $client_id, $from, $to, $row->gidMediaType);
            foreach ($comp_data as $value) {
                $outArr[] = [
                    'Media_name' => $row->MediaType,
                    'Count' => $value['Count'],
                    'ave' => $value['ave'] ?? 0,
                    'Client_name' => $value['label']
                ];
            }
        }

        $groupedData = [];

        foreach ($outArr as $record) {
            $mediaName = $record['Media_name'];
            if (!isset($groupedData[$mediaName])) {
                $groupedData[$mediaName] = [];
            }
            $groupedData[$mediaName][] = $record;
        }

        return $groupedData;
    }

    public function getNewsDetails($gidMediaType, $client_id, $from = null, $to = null)
    {
        $query = DB::table('news_details')
            ->where('media_type_id', $gidMediaType);

        if ($from && $to) {
            $query->whereBetween('create_at', [$from, $to]);
        }

        $query->whereRaw("FIND_IN_SET(?, company)", [$client_id]);

        $result = $query->get();
        
        foreach ($result as &$value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;

            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $circulation_fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $circulation_fig;
            }

            $value->ave = $ave;
        }

        return $result;
    }

    public function getCompDataM($timeframe, $client_id, $from = null, $to = null, $gidMediaType = null)
    {
        $result = DB::table('competitor')
            ->where('client_id', $client_id)
            ->get();
        
        $outArr = [];

        foreach ($result as $row) {
            $news_data = $this->getCompNewsByKeyM($row->Keywords, $client_id, $from, $to, $gidMediaType);
            $totalAve = array_reduce($news_data, function($carry, $item) {
                return $carry + ($item['ave'] ?? 0);
            }, 0);

            $outArr[] = [
                'label' => $row->Competitor_name,
                'Count' => count($news_data),
                'ave' => $totalAve
            ];
        }

        return $outArr;
    }

    public function getCompNewsByKeyM($Keywords, $client_id, $from = null, $to = null, $gidMediaType = null)
    {
        $query = DB::table('news_details');

        if ($from !== null && $to !== null) {
            $query->whereBetween('create_at', [$from, $to]);
        }

        if ($gidMediaType !== null) {
            $query->where('media_type_id', $gidMediaType);
        }

        $query->whereRaw("NOT FIND_IN_SET(?, company)", [$client_id]);

        $keywords = explode(',', $Keywords);
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);
            $query->orWhereRaw("FIND_IN_SET(?, keywords) >", [0]);
        }

        $result = $query->get()->toArray();

        foreach ($result as &$value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;

            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $circulation_fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $circulation_fig;
            }

            $value->ave = $ave;
        }

        return $result;
    }
}
