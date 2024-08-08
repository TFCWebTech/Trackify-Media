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

    //publication queries 
    public function getPublicationDataByID($timeframe, $client_id, $from = null, $to = null) {
        $result = DB::table('mediaoutlet')->get()->toArray();
        $outArr = [];
    
        $client_name = $this->getClientNameByID($client_id);
        foreach ($result as $row) {
            $news_data = $this->getNewsDetails2($row->gidMediaOutlet, $client_id, $from, $to);
            
            $totalAve = array_reduce($news_data, function($carry, $item) {
                return $carry + ($item->ave ?? 0);
            }, 0);
    
            $outArr[] = [
                'Publication_name' => $row->MediaOutlet,
                'Count' => count($news_data),
                'ave' => $totalAve,
                'Client_name' => $client_name // Add client name
            ];
    
            $comp_data = $this->getCompData2('daily', $client_id, $from, $to, $row->gidMediaOutlet);
            foreach ($comp_data as $value) {
                $outArr[] = [
                    'Publication_name' => $row->MediaOutlet,
                    'Count' => $value['Count'],
                    'ave' => $value['ave'] ?? 0,
                    'Client_name' => $value['label']
                ];
            }
        }
        
        usort($outArr, function ($a, $b) {
            return $b['Count'] - $a['Count'];
        });
    
        $outArr = array_slice($outArr, 0, 5);
    
        $groupedData = [];
        foreach ($outArr as $record) {
            $PublicationName = $record['Publication_name'];
            if (!isset($groupedData[$PublicationName])) {
                $groupedData[$PublicationName] = [];
            }
            $groupedData[$PublicationName][] = $record;
        }
        return $groupedData;
    }

    public function getNewsDetails2($gidMediaOutlet, $client_id, $from = null, $to = null) {
        $query = DB::table('news_details')
                   ->where('publication_id', $gidMediaOutlet);
        
        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    
        $query->whereRaw("FIND_IN_SET(?, client_id)", [$client_id]);
    
        $result = $query->get()->toArray();
        
        foreach ($result as &$value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;
    
            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $Circulation_Fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }
            $value->ave = $ave;
        }
        return $result;
    }

    public function getCompData2($timeframe, $client_id, $from = null, $to = null, $gidMediaOutlet = null) {
        $result = DB::table('competitor')
                    ->where('client_id', $client_id)
                    ->get()
                    ->toArray();
        $outArr = [];
    
        foreach ($result as $row) {
            $news_data = $this->getCompNewsByKey2($row->Keywords, $client_id, $from, $to, $gidMediaOutlet);
            $totalAve = array_reduce($news_data, function($carry, $item) {
                return $carry + ($item->ave ?? 0);
            }, 0);
    
            $outArr[] = [
                'label' => $row->Competitor_name,
                'Count' => count($news_data),
                'ave' => $totalAve,
            ];
        }
        return $outArr;
    }
    public function getCompNewsByKey2($Keywords, $client_id, $from = null, $to = null, $gidMediaOutlet) {
        $query = DB::table('news_details');
    
        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    
        if ($gidMediaOutlet) {
            $query->where('publication_id', $gidMediaOutlet);
        }
    
        $query->whereRaw("NOT FIND_IN_SET(?, client_id)", [$client_id]);
    
        $keywordsArray = explode(',', $Keywords);
        $query->where(function($q) use ($keywordsArray) {
            foreach ($keywordsArray as $keyword) {
                $keyword = trim($keyword);
                $q->orWhereRaw("FIND_IN_SET(?, keywords) > 0", [$keyword]);
            }
        });
    
        $result = $query->get()->toArray();
    
        foreach ($result as &$value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;
    
            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $Circulation_Fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }
            $value->ave = $ave;
        }
        return $result;
    }


    //geograpy queries 
    public function getGeographyDataByID($timeframe, $client_id, $from = null, $to = null) {
        $result = DB::table('edition')->get(); // Get results as a collection
        $outArr = [];
        $client_name = $this->getClientNameByID($client_id);
    
        foreach ($result as $row) {
            $news_data = $this->getNewsDetails3($row->gidEdition, $client_id, $from, $to);
            
            // Ensure $news_data is a collection
            if ($news_data instanceof \Illuminate\Support\Collection) {
                $totalAve = $news_data->sum('ave'); // Sum using collection method
            } else {
                // If it's not a collection, convert it
                $totalAve = array_sum(array_column($news_data, 'ave'));
            }
            
            $outArr[] = [
                'Edition_name' => $row->Edition,
                'Count' => $news_data->count(), // News count
                'ave' => $totalAve, // Total ave value
                'Client_name' => $client_name // Add client name
            ];
    
            $comp_data = $this->getCompData3('daily', $client_id, $from, $to, $row->gidEdition);
            foreach ($comp_data as $value) {
                $outArr[] = [
                    'Edition_name' => $row->Edition,
                    'Count' => $value['Count'], // Ensure 'Count' key exists
                    'ave' => $value['ave'] ?? 0, // Ensure 'ave' index exists
                    'Client_name' => $value['label']
                ];
            }
        }
    
        // Sort the array by Count in descending order
        usort($outArr, function ($a, $b) {
            return $b['Count'] - $a['Count'];
        });
    
        // Get only the top 5 records
        $outArr = array_slice($outArr, 0, 5);
    
        // Group the data by 'Edition_name'
        $groupedData = [];
        foreach ($outArr as $record) {
            $EditionName = $record['Edition_name'];
            if (!isset($groupedData[$EditionName])) {
                $groupedData[$EditionName] = [];
            }
            $groupedData[$EditionName][] = $record;
        }
        return $groupedData;
    }
    public function getNewsDetails3($gidEdition, $client_id, $from = null, $to = null) {
        $query = DB::table('news_details')
            ->where('edition_id', $gidEdition);
        
        if ($from !== null && $to !== null) {
            $query->whereBetween('created_at', [$from, $to]);
        }
        
        $query->whereRaw("FIND_IN_SET(?, client_id)", [$client_id]);
        
        $result = $query->get(); // This returns a collection
        
        foreach ($result as $value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;
        
            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $Circulation_Fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }
            $value->ave = $ave;
        }
        return $result;
    }
    public function getCompData3($timeframe, $client_id, $from = null, $to = null, $gidEdition = null) {
        $result = DB::table('competitor')
                    ->where('client_id', $client_id)
                    ->get()
                    ->toArray();
        $outArr = [];
        foreach ($result as $row) {
            $news_data = $this->getCompNewsByKey3($row->Keywords, $client_id, $from, $to, $gidEdition);
            $totalAve = array_reduce($news_data, function($carry, $item) {
                return $carry + ($item->ave ?? 0);
            }, 0);
    
            $outArr[] = [
                'label' => $row->Competitor_name,
                'Count' => count($news_data),
                'ave' => $totalAve,
            ];
        }
        return $outArr;
        
    }
    public function getCompNewsByKey3($Keywords, $client_id, $from = null, $to = null, $gidEdition) {
        $query = DB::table('news_details');
    
        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    
        if ($gidEdition) {
            $query->where('edition_id', $gidEdition);
        }
    
        $query->whereRaw("NOT FIND_IN_SET(?, client_id)", [$client_id]);
        $keywordsArray = explode(',', $Keywords);
        $query->where(function($q) use ($keywordsArray) {
            foreach ($keywordsArray as $keyword) {
                $keyword = trim($keyword);
                $q->orWhereRaw("FIND_IN_SET(?, keywords) > 0", [$keyword]);
            }
        });
    
        $result = $query->get()->toArray();
    
        foreach ($result as &$value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;
    
            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $Circulation_Fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }
            $value->ave = $ave;
        }
        return $result;

    }

    //jpurnalist queries
    public function getJournalistDataByID($timeframe, $client_id, $from = null, $to = null) {
        $result = DB::table('journalist')->get()->toArray();
        $outArr = [];
        $client_name = $this->getClientNameByID($client_id);
    
        foreach ($result as $row) {
            $news_data = $this->getNewsDetails4($row->gidJournalist, $client_id, $from, $to);
            $totalAve = array_reduce($news_data, function($carry, $item) {
                return $carry + ($item->ave ?? 0);
            }, 0);
    
            $outArr[] = [
                'Journalist_name' => $row->Journalist,
                'Count' => count($news_data),
                'ave' => $totalAve,
                'Client_name' => $client_name
            ];
    
            $comp_data = $this->getCompData4('daily', $client_id, $from, $to, $row->gidJournalist);
            foreach ($comp_data as $value) {
                $outArr[] = [
                    'Journalist_name' => $row->Journalist,
                    'Count' => $value['Count'],
                    'ave' => $value['ave'] ?? 0,
                    'Client_name' => $value['label']
                ];
            }
        }
    
        // Get only the top 5 records
        $outArr = array_slice($outArr, 0, 5);
    
        $groupedData = [];
        foreach ($outArr as $record) {
            $JournalistName = $record['Journalist_name'];
            if (!isset($groupedData[$JournalistName])) {
                $groupedData[$JournalistName] = [];
            }
            $groupedData[$JournalistName][] = $record;
        }
    
        return $groupedData;
    }

    public function getNewsDetails4($gidJournalist, $client_id, $from = null, $to = null) {
        $query = DB::table('news_details')
                    ->where('journalist_id', $gidJournalist);
    
        if ($from !== null && $to !== null) {
            $query->whereBetween('create_at', [$from, $to]);
        }
    
        $query->whereRaw("FIND_IN_SET(?, company)", [$client_id]);
    
        $result = $query->get()->toArray();
        foreach ($result as $value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;
        
            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $Circulation_Fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }
            $value->ave = $ave;
        }
        return $result;
    }
    public function getCompData4($timeframe, $client_id, $from = null, $to = null, $gidJournalist = null) {
        $result = DB::table('competitor')
                    ->where('client_id', $client_id)
                    ->get()->toArray();
    
        $outArr = [];
        foreach ($result as $row) {
            $news_data = $this->getCompNewsByKey4($row->Keywords, $client_id, $from, $to, $gidJournalist);
            $totalAve = array_reduce($news_data, function($carry, $item) {
                return $carry + ($item->ave ?? 0);
            }, 0);
    
            $outArr[] = [
                'label' => $row->Competitor_name,
                'Count' => count($news_data),
                'ave' => $totalAve,
            ];
        }
    
        return $outArr;
    }
    public function getCompNewsByKey4($Keywords, $client_id, $from = null, $to = null, $gidJournalist) {
        $query = DB::table('news_details');
    
        if ($from !== null && $to !== null) {
            $query->whereBetween('create_at', [$from, $to]);
        }
    
        if ($gidJournalist !== null) {
            $query->where('journalist_id', $gidJournalist);
        }
    
        $query->whereRaw("NOT FIND_IN_SET(?, client_id)", [$client_id]);
    
        $keywordsArray = explode(',', $Keywords);
        $query->where(function($q) use ($keywordsArray) {
            foreach ($keywordsArray as $keyword) {
                $q->orWhereRaw("FIND_IN_SET(?, keywords) > 0", [trim($keyword)]);
            }
        });
    
        $result = $query->get()->toArray();
    
        foreach ($result as &$value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;
    
            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $Circulation_Fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }
            $value->ave = $ave;
        }
        return $result;
    }

    //size quueries
    public function getSizeDataCompByID($timeframe, $client_id, $from = null, $to = null)
    {
        $outArr = [];
    
        // Get competitor data
        $comp_data = $this->getCompititersWithSize($client_id, $from, $to);
    
        // Get client data
        $client_data = $this->getClientSize($client_id, $from, $to);
        $client_name = $this->getClientNameByID($client_id);
    
        // Aggregate data by category
        $aggregatedData = [];
    
        foreach ($client_data as $value) {
            $category = $value->category ?? 'Unknown';
            if (!isset($aggregatedData[$category])) {
                $aggregatedData[$category] = [
                    'label' => $client_name,
                    'count' => 0,
                    'category' => $category,
                    'ave' => 0,
                ];
            }
            $aggregatedData[$category]['count'] += $value->count ?? 0;
            $aggregatedData[$category]['ave'] += $value->ave ?? 0;
        }
    
        // Convert aggregated data to array format
        foreach ($aggregatedData as $data) {
            $outArr[] = $data;
        }
    
        // Merge client data with competitor data, ensuring both are arrays
        $final_array = is_array($comp_data) ? array_merge($outArr, $comp_data) : $outArr;
    
        return $final_array;
    }
    
    public function getCompititersWithSize($client_id, $from = null, $to = null)
    {
        $competitors = DB::table('competitor')
            ->where('client_id', $client_id)
            ->get();
    
        $outArr = [];
    
        foreach ($competitors as $row) {
            $news_data = $this->getSizeofClient($row->Keywords, $client_id, $from, $to);
            $totalAve = collect($news_data)->sum('ave');
            $categoryCounts = [];
    
            foreach ($news_data as $value) {
                $category = $value->category;
    
                if (!isset($categoryCounts[$category])) {
                    $categoryCounts[$category] = 0;
                }
                $categoryCounts[$category]++;
    
                $outArr[] = [
                    'label' => $row->Competitor_name,
                    'category' => $category,
                    'Count' => $categoryCounts[$category],
                    'ave' => $totalAve,
                ];
            }
        }
    
        return $outArr;
    }
    
    public function getSizeofClient($Keywords, $client_id, $from = null, $to = null)
    {
        $query = DB::table('news_details')
            ->select('category', 'media_type_id', 'publication_id', 'sizeofArticle');
    
        if ($from !== null && $to !== null) {
            $query->whereBetween('create_at', [$from, $to]);
        }
    
        $query->whereRaw("NOT FIND_IN_SET(?, client_id)", [$client_id]);
    
        $query->where(function($q) use ($Keywords) {
            foreach (explode(',', $Keywords) as $keyword) {
                $q->orWhereRaw("FIND_IN_SET(?, keywords) > 0", [trim($keyword)]);
            }
        });
    
        $query->groupBy('category', 'media_type_id', 'publication_id', 'sizeofArticle');
    
        $result = $query->get()->toArray();
    
        foreach ($result as &$value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;
    
            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $Circulation_Fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }
            $value->ave = $ave;
        }
    
        return $result;
    }
    
    public function getClientSize($client_id, $from = null, $to = null)
    {
        $query = DB::table('news_details')
            ->select('category', 'media_type_id', 'publication_id', 'sizeofArticle', DB::raw('COUNT(*) as count'));
    
        if ($from !== null && $to !== null) {
            $query->whereBetween('create_at', [$from, $to]);
        }
    
        $query->whereRaw("FIND_IN_SET(?, company)", [$client_id]);
    
        // Group by all selected columns to avoid SQL error
        $query->groupBy('category', 'media_type_id', 'publication_id', 'sizeofArticle');
    
        $result = $query->get()->toArray();
    
        foreach ($result as &$value) {
            $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
            $ave = 0;
    
            if (!empty($rates_data)) {
                $article_size = $value->sizeofArticle ?? 0;
                $rate = $rates_data->Rate;
                $Circulation_Fig = $rates_data->Circulation_Fig;
                $ave = 3 * $article_size * $rate * $Circulation_Fig;
            }
            $value->ave = $ave;
        }
    
        return $result;
    }

    //AVE 
    public function getAVEofClient($Keywords, $client_id, $from = null, $to = null)
{
    $query = DB::table('news_details')
        ->select('*');

    if ($from !== null && $to !== null) {
        $query->whereBetween('create_at', [$from, $to]);
    }

    $query->whereRaw('NOT FIND_IN_SET(?, client_id)', [$client_id]);

    $keywords = explode(',', $Keywords);
    foreach ($keywords as $keyword) {
        $query->orWhereRaw('FIND_IN_SET(?, keywords) > 0', [trim($keyword)]);
    }

    $result = $query->get()->toArray();

    $total_ave = 0;
    $news_count = 0;

    foreach ($result as $value) {
        $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
        $ave = 0;
        $news_count++;

        if (!empty($rates_data)) {
            $article_size = $value->sizeofArticle ?? 0;
            $rate = $rates_data->Rate;
            $circulation_fig = $rates_data->Circulation_Fig;
            $ave = 3 * $article_size * $rate * $circulation_fig;
        }

        $total_ave += $ave;
    }

    return [
        [
            'news_count' => $news_count,
            'total_ave' => $total_ave
        ]
    ];
}
public function getCompetitorsWithAVE($client_id, $from = null, $to = null)
{
    $competitors = DB::table('competitor')
        ->where('client_id', $client_id)
        ->get()
        ->toArray();

    $outArr = [];

    foreach ($competitors as $row) {
        $news_count = $this->getAVEofClient($row->Keywords, $client_id, $from, $to);
        $outArr[] = [
            'label' => $row->Competitor_name,
            'count' => $news_count[0]['news_count'],
            'ave' => $news_count[0]['total_ave']
        ];
    }

    return $outArr;
}
public function getAVEDataByID($timeframe, $client_id, $from = null, $to = null)
{
    $client_name = $this->getClientNameByID($client_id);
    $comp_data = $this->getCompetitorsWithAVE($client_id, $from, $to);
    $client_data = $this->getClientAVE($client_id, $from, $to);

    // Add client data to competitors data
    $comp_data[] = [
        'label' => $client_name,
        'count' => $client_data[0]['news_count'],
        'ave' => $client_data[0]['total_ave']
    ];

    return $comp_data;
}
public function getClientAVE($client_id, $from = null, $to = null)
{
    // Query the news_details table
    $query = DB::table('news_details')
        ->select('*');

    // Apply date filters if provided
    if ($from !== null && $to !== null) {
        $query->whereBetween('create_at', [$from, $to]);
    }

    // Apply filter for client_id
    $query->whereRaw('FIND_IN_SET(?, client_id) > 0', [$client_id]);

    // Execute query and get results as an array
    $result = $query->get()->toArray();

    $total_ave = 0;
    $news_count = 0;

    // Process each result
    foreach ($result as $value) {
        $rates_data = $this->getRates($value->media_type_id, $value->publication_id);
        $ave = 0;
        $news_count++;

        if (!empty($rates_data)) {
            $article_size = $value->sizeofArticle ?? 0;
            $rate = $rates_data->Rate;
            $circulation_fig = $rates_data->Circulation_Fig;
            $ave = 3 * $article_size * $rate * $circulation_fig;
        }

        $total_ave += $ave;
    }

    return [
        [
            'news_count' => $news_count,
            'total_ave' => $total_ave
        ]
    ];
}
}
