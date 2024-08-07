<?php

namespace App\Models\clientDashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Pro_Compare_model extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'client';
    protected $primaryKey = 'client_id';

    public function getClientName($client_id)
    {
        return DB::table('client')
            ->select('client_name')
            ->where('client_id', $client_id)
            ->first(); // Use first() to get a single result
    }

    public function getClientNewsCount($timeframe, $client_id, $from = null, $to = null)
{
    $query = DB::table('news_details')
        ->select('*');

    // if ($from !== null && $to !== null) {
    //     $query->whereBetween('create_at', [$from, $to]);
    // }

    $query->whereRaw("FIND_IN_SET(?, company)", [$client_id]);

    $result = $query->get();
    $total_ave = 0;
    $news_count = 0;

    foreach ($result as $value) {
        $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
        $ave = 0;
        if ($rates_data) { // Check if rates_data is not null
            $article_size = $value->sizeofArticle ?? 0;
            $rate = $rates_data->Rate ?? 0; // Access properties using -> for stdClass
            $Circulation_Fig = $rates_data->Circulation_Fig ?? 0; // Access properties using -> for stdClass
            $ave = 3 * $article_size * $rate * $Circulation_Fig;
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
    return DB::table('AddRate')
        ->select('Rate', 'Circulation_Fig')
        ->where('gidMediaType', $gidMediaType)
        ->where('gidMediaOutlet', $gidMediaOutlet)
        ->first(); // Use first() to get a single result
}

public function getMediaDataByID($timeframe, $client_id, $from = null, $to = null)
    {
        $result = DB::table('mediatype')->get()->toArray();
        $outArr = array();
        
        // Fetch client name
        $client_name = $this->getClientNameByID($client_id);

        foreach ($result as $row) {
            $news_data = $this->getNewsDetailsByID($row->gidMediaType, $client_id, $from, $to);

            // Sum up the 'ave' values from news_data
            $totalAve = array_reduce($news_data, function($carry, $item) {
                return $carry + ($item->ave ?? 0);
            }, 0);

            $outArr[] = array(
                'Media_name' => $row->MediaType,
                'Count' => count($news_data), // News count
                'ave' => $totalAve, // Total ave value
                'Client_name' => $client_name // Add client name
            );

            $comp_data = $this->getCompDataM('daily', $client_id, $from, $to, $row->gidMediaType);
            foreach ($comp_data as $value) {
                $outArr[] = array(
                    'Media_name' => $row->MediaType,
                    'Count' => $value['Count'], // Use 'Count' instead of 'count'
                    'ave' => $value['ave'] ?? 0, // Ensure 'ave' index exists
                    'Client_name' => $value['label']
                );
            }
        }

        $groupedData = array();

        foreach ($outArr as $record) {
            $mediaName = $record['Media_name'];
            if (!isset($groupedData[$mediaName])) {
                $groupedData[$mediaName] = array();
            }
            $groupedData[$mediaName][] = $record;
        }

        return $groupedData;
    }

    public function getNewsDetailsByID($gidMediaType, $client_id, $from = null, $to = null)
{
    $query = DB::table('news_details')
        ->where('media_type_id', $gidMediaType);

    if ($from !== null && $to !== null) {
        $query->whereBetween('create_at', [$from, $to]);
    }

    $query->whereRaw("FIND_IN_SET(?, company)", [$client_id]);

    $result = $query->get()->toArray(); // This returns an array of objects

    foreach ($result as &$value) {
        $rates_data = $this->getRates($value->media_type_id, $value->publication_id); // Note the object access with '->'
        $ave = 0;

        if (!empty($rates_data)) {
            $article_size = $value->sizeofArticle ?? 0;
            $rate = $rates_data->Rate; // Assuming getRates returns an object
            $Circulation_Fig = $rates_data->Circulation_Fig;
            $ave = 3 * $article_size * $rate * $Circulation_Fig;
        }
        $value->ave = $ave;
    }
    return $result;
}

    public function getClientNameByID($client_id)
    {
        $result = DB::table('client')
            ->select('client_name')
            ->where('client_id', $client_id)
            ->first();

        return $result ? $result->client_name : '';
    }

    public function getCompDataM($timeframe, $client_id, $from = null, $to = null, $gidMediaType = null)
    {
        $result = DB::table('competitor')
            ->where('client_id', $client_id)
            ->get()
            ->toArray();
        $outArr = array();
        foreach ($result as $row) {
            $news_data = $this->getCompNewsByKeyM($row->Keywords, $client_id, $from, $to, $gidMediaType);
            $totalAve = array_reduce($news_data, function($carry, $item) {
                return $carry + ($item->ave ?? 0);
            }, 0);

            $outArr[] = array(
                'label' => $row->Competitor_name,
                'Count' => count($news_data), // News count
                'ave' => $totalAve, // Total ave value
            );
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

        $query->where(function ($q) use ($Keywords) {
            foreach (explode(',', $Keywords) as $keyword) {
                $keyword = trim($keyword); // Trim any whitespace around keywords
                $q->orWhereRaw("FIND_IN_SET(?, keywords) > 0", [$keyword]);
            }
        });

        $result = $query->get()->toArray();
        foreach ($result as &$value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;

            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data['Rate'];
                $Circulation_Fig = $rates_data['Circulation_Fig'];
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }
            $value->ave = $ave;
        }
        return $result;
    }
}
