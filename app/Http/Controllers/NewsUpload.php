<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\NewsUpload_Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\ArticalImage; 
use App\Models\Competitor_Model; 
use App\Models\Industry_model; 
use App\Models\Client_Model; 
use App\Models\client_competetor_industry;
use App\Models\news_artical_model;

class NewsUpload extends Controller
{
    public function index()
    {
        $media_type = DB::table('mediatype')
        ->select('*')   
        ->get();  
        $get_agency = DB::table('agency')
        ->select('*')   
        ->get();
        $news_city = DB::table('newscity')
        ->select('*')   
        ->get();
        $clientModel = new Client_Model();
        $getKeywords = $clientModel->getKeywords();
       
        $newsModel = new Client_Model();
        $get_clients  = $newsModel->getClients();
        
        // Get all competitors with client information
        $get_competitors = DB::table('competitor')
            ->leftJoin('client', 'competitor.client_id', '=', 'client.client_id')
            ->select('competitor.competitor_id', 'competitor.Competitor_name', 'competitor.client_id', 'client.client_name', 'competitor.Keywords')
            ->get()
            ->toArray();
        
        // Get all industries with client information
        // Handle comma-separated client_ids in industry table
        $industries = DB::table('industry')->get();
        $clients = DB::table('client')->select('client_id', 'client_name')->get();
        $clientMap = [];
        foreach ($clients as $client) {
            $clientMap[$client->client_id] = $client->client_name ?? '';
        }
        
        $get_industries = [];
        foreach ($industries as $industry) {
            $clientNames = [];
            if (!empty($industry->client_id)) {
                $clientIds = explode(',', $industry->client_id);
                foreach ($clientIds as $clientId) {
                    $clientId = trim($clientId);
                    if (!empty($clientId) && isset($clientMap[$clientId])) {
                        $clientNames[] = $clientMap[$clientId];
                    }
                }
            }
            
            $get_industries[] = [
                'Industry_id' => $industry->Industry_id,
                'Industry_name' => $industry->Industry_name ?? '',
                'client_id' => $industry->client_id ?? '',
                'client_names' => implode(', ', $clientNames),
                'Keywords' => $industry->Keywords ?? ''
            ];
        }
        
        return view('news_upload', compact('media_type', 'get_agency', 'news_city','getKeywords','get_clients', 'get_competitors', 'get_industries'));

    }

    public function saveArticalImage(Request $request)
    {
        $response = [];
    
        if ($request->hasFile('image_upload')) {
            $image_data = [];
    
            foreach ($request->file('image_upload') as $file) {
                $ext = $file->getClientOriginalExtension();
                $mtime = uniqid(microtime(), true);
                $uniqueid = substr(md5($mtime), 0, 8);
                $currentDate = date('Y-m-d');
                $image_upload = 'image_upload_' . $currentDate . $uniqueid . '.' . $ext;
    
                // Store the file in the 'uploads' disk
                $path = $file->storeAs('', $image_upload, 'uploads');
    
                if ($path) {
                    // Insert image name into the database
                    $articalImage = ArticalImage::create([
                        'artical_images_name' => $image_upload,
                    ]);
    
                    // Generate the URL using the 'uploads' disk configuration
                    $image_url = Storage::disk('uploads')->url($image_upload);
    
                    $image_data[] = [
                        'image_url' => $image_url,
                        'article_images_id' => $articalImage->id,
                    ];
                } else {
                    $response['success'] = false;
                    $response['error'] = 'Failed to store the file';
                    return response()->json($response);
                }
            }
    
            if (!empty($image_data)) {
                $response['success'] = true;
                $response['image_data'] = $image_data;
            } else {
                $response['success'] = false;
                $response['error'] = 'Failed to upload files';
            }
        } else {
            $response['success'] = false;
            $response['error'] = 'No files uploaded';
        }
    
        return response()->json($response);
    }

    public function searchKeywords(Request $request)
    {
        $description = $request->input('description', '');
        
        // Clean HTML tags and decode HTML entities (e.g. &amp; -> &) so word boundaries work on rich text
        $cleanDescription = html_entity_decode(strip_tags((string)$description), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $cleanDescription = str_replace(["\xc2\xa0", "&nbsp;"], ' ', $cleanDescription);
        
        // Get the keywords from your model
        $clientModel = new Client_Model();
        $keywords = $clientModel->getKeywords();
        
        $matched_keywords = [];
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword); // Trim each individual keyword
            if (empty($keyword) || mb_strlen($keyword) <= 1) {
                continue;
            }
            
            // Create a regex pattern to match whole words only
            $pattern = '/\b' . preg_quote($keyword, '/') . '\b/i'; // \b ensures word boundaries

            if (preg_match($pattern, $cleanDescription)) { // Case-insensitive comparison
                // If the keyword is found as a whole word in the description, add it to the matched keywords array
                $matched_keywords[] = $keyword;
            }
        }
        // Return the matched keywords as a JSON response
        return response()->json(array_values(array_unique($matched_keywords)));
    }

    public function getClientsFromKeywords(Request $request)
    {
        // Get keywords from POST request
        $keywordsToMatch = $request->input('keywordData');
    
        // Ensure keywordsToMatch is an array
        if (!is_array($keywordsToMatch)) {
            $keywordsToMatch = explode(',', $keywordsToMatch);
        }
    
        // Normalize keywords to lower case for case-insensitive matching
        $keywordsToMatch = array_map('strtolower', array_map('trim', $keywordsToMatch));
    
        // Fetch client data from the model
        $newsModel = new Client_Model();
        $getClientsData = $newsModel->getClients();

       
        // Array to hold matching clients
        $matchingClients = [];
    
        // Iterate over the client data
        foreach ($getClientsData as $client) {
            // Ensure client_keywords is a string before processing
            if (isset($client['client_keywords']) && is_string($client['client_keywords'])) {
                // Get client keywords and normalize them to lower case
                $clientKeywords = array_map('strtolower', array_map('trim', explode(',', $client['client_keywords'])));
    
                // Check for intersection of client keywords and keywords to match
                $matches = array_intersect($clientKeywords, $keywordsToMatch);
    
                // If there is a match, add client to the matching clients array
                if (!empty($matches)) {
                    $matchingClients[] = $client['client_id'];
                }
            }
        }
    	 $competitors = DB::table('competitor')->get(); // You could optimize with pluck() or other methods for large sets

        foreach ($competitors as $competitor) {
            // Check if competitor_keywords exists and is not null
            if (!empty($competitor->Keywords)) {
            
                $keywords = array_map('strtolower', array_map('trim', explode(',', $competitor->Keywords)));
                $matches = array_intersect($keywords, $keywordsToMatch);
                //print_r($competitor->client_id);die;
                if (!empty($matches)) {
                    $matchingClients[] = $competitor->client_id;
                }
            }
        }
        $industrys = DB::table('industry')->get(); // You could optimize with pluck() or other methods for large sets

        foreach ($industrys as $industry) {
            // Check if industry Keywords exists and is not null
            if (!empty($industry->Keywords)) {
                $keywords = array_map('strtolower', array_map('trim', explode(',', $industry->Keywords)));
                $matches = array_intersect($keywords, $keywordsToMatch);
                //print_r($matches);die;
                if (!empty($matches)) {
                    $matchingClients[] =$industry->client_id;
                }
            }
        }
        // Return matching client IDs as a comma-separated string
        return response()->json($matchingClients);
    }

    public function getMatchingRecordsFromKeywords(Request $request)
    {
        // Get keywords from POST request
        $keywordsToMatch = $request->input('keywordData');
    
        // Ensure keywordsToMatch is an array
        if (!is_array($keywordsToMatch)) {
            $keywordsToMatch = explode(',', $keywordsToMatch);
        }
    
        // Normalize keywords to lower case for case-insensitive matching
        $keywordsToMatch = array_filter(array_map('strtolower', array_map('trim', $keywordsToMatch)));
    
        // Array to hold matching records
        $matchingClients = [];
        $matchedClientIds = [];
        $matchingCompetitors = [];
        $matchingIndustries = [];
    
        // Match with Clients
        $clientModel = new Client_Model();
        $getClientsData = $clientModel->getClients();
    
        foreach ($getClientsData as $client) {
            $clientKeywords = [];
            if (!empty($client['client_name'])) {
                $clientKeywords[] = strtolower(trim($client['client_name']));
            }
            if (isset($client['client_keywords']) && is_string($client['client_keywords']) && !empty($client['client_keywords'])) {
                $clientKeywords = array_merge($clientKeywords, array_map('strtolower', array_map('trim', explode(',', $client['client_keywords']))));
            }
            $matches = array_intersect($clientKeywords, $keywordsToMatch);

            if (!empty($matches)) {
                $matchingClients[] = [
                    'client_id' => $client['client_id'],
                    'client_name' => $client['client_name'] ?? '',
                    'client_keywords' => $client['client_keywords'] ?? ''
                ];
                $matchedClientIds[] = (string)$client['client_id'];
            }
        }
    
        // Match with Competitors
        $competitors = DB::table('competitor')
            ->leftJoin('client', 'competitor.client_id', '=', 'client.client_id')
            ->select('competitor.*', 'client.client_name')
            ->get();
    
        foreach ($competitors as $competitor) {
            $competitorKeywords = [];
            if (!empty($competitor->Competitor_name)) {
                $competitorKeywords[] = strtolower(trim($competitor->Competitor_name));
            }
            if (!empty($competitor->Keywords)) {
                $compKeys = array_map('strtolower', array_map('trim', explode(',', $competitor->Keywords)));
                $competitorKeywords = array_merge($competitorKeywords, $compKeys);
            }
            $matches = array_intersect($competitorKeywords, $keywordsToMatch);

            if (!empty($matches)) {
                $matchingCompetitors[] = [
                    'competitor_id' => $competitor->competitor_id,
                    'competitor_name' => $competitor->Competitor_name ?? '',
                    'client_id' => $competitor->client_id,
                    'client_name' => $competitor->client_name ?? '',
                    'keywords' => $competitor->Keywords ?? ''
                ];

                // If competitor matched, also ensure the client it belongs to is included in matching clients
                if (!empty($competitor->client_id) && !in_array((string)$competitor->client_id, $matchedClientIds)) {
                    $matchedClientIds[] = (string)$competitor->client_id;
                    $matchingClients[] = [
                        'client_id' => $competitor->client_id,
                        'client_name' => $competitor->client_name ?? '',
                        'client_keywords' => ''
                    ];
                }
            }
        }
    
        // Match with Industries
        // Get all active industries
        $industries = DB::table('industry')
            ->where(function($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->get();
        
        // Get all clients for mapping
        $clients = DB::table('client')->get();
        $clientMap = [];
        foreach ($clients as $client) {
            $clientMap[$client->client_id] = $client->client_name ?? '';
        }
    
        foreach ($industries as $industry) {
            $industryKeywords = [];
            $indWords = [];
            if (!empty($industry->Industry_name)) {
                $nameClean = strtolower(trim($industry->Industry_name));
                $industryKeywords[] = $nameClean;
                $indWords = array_merge($indWords, array_filter(preg_split('/[\s,\-\/]+/', $nameClean)));
            }
            if (!empty($industry->Keywords)) {
                $indKeys = array_map('strtolower', array_map('trim', explode(',', $industry->Keywords)));
                $industryKeywords = array_merge($industryKeywords, $indKeys);
                foreach ($indKeys as $ik) {
                    $indWords = array_merge($indWords, array_filter(preg_split('/[\s\-\/]+/', $ik)));
                }
            }
            $indWords = array_unique(array_filter($indWords, function($w) {
                return mb_strlen($w) >= 3 && !in_array($w, ['industry', 'industries', 'with', 'from', 'that', 'this', 'have', 'more', 'some', 'than', 'and', 'the', 'for']);
            }));

            // 1. Direct match with selected keywords
            $directMatches = array_intersect($industryKeywords, $keywordsToMatch);

            // 2. Word-level match
            $wordMatches = [];
            foreach ($keywordsToMatch as $kw) {
                $kwLower = strtolower(trim($kw));
                if (in_array($kwLower, $indWords)) {
                    $wordMatches[] = $kwLower;
                }
                $userWords = array_filter(preg_split('/[\s\-\/]+/', $kwLower));
                $overlap = array_intersect($userWords, $indWords);
                if (!empty($overlap)) {
                    $wordMatches = array_merge($wordMatches, $overlap);
                }
            }

            $isMatch = (!empty($directMatches) || !empty($wordMatches));

            // 3. Client association match: If this industry is linked to a matched client
            if (!$isMatch && !empty($industry->client_id)) {
                $clientIdsArray = array_map('trim', explode(',', $industry->client_id));
                foreach ($clientIdsArray as $cid) {
                    if (!empty($cid) && in_array((string)$cid, $matchedClientIds)) {
                        $clientIndustryCount = DB::table('industry')
                            ->where(function($q) {
                                $q->whereNull('is_active')->orWhere('is_active', 1);
                            })
                            ->whereRaw('FIND_IN_SET(?, client_id)', [$cid])
                            ->count();
                        if ($clientIndustryCount <= 1) {
                            $isMatch = true;
                            break;
                        }
                    }
                }
            }

            if ($isMatch) {
                // Handle comma-separated client_ids in industry table
                $industryClientIds = $industry->client_id ?? '';
                $clientIdsArray = !empty($industryClientIds) ? explode(',', $industryClientIds) : [];
                $clientNames = [];
                
                foreach ($clientIdsArray as $clientId) {
                    $clientId = trim($clientId);
                    if (!empty($clientId) && isset($clientMap[$clientId])) {
                        $clientNames[] = $clientMap[$clientId];
                        if (!in_array((string)$clientId, $matchedClientIds)) {
                            $matchedClientIds[] = (string)$clientId;
                            $matchingClients[] = [
                                'client_id' => $clientId,
                                'client_name' => $clientMap[$clientId],
                                'client_keywords' => ''
                            ];
                        }
                    }
                }

                $matchingIndustries[] = [
                    'industry_id' => $industry->Industry_id,
                    'Industry_id' => $industry->Industry_id,
                    'industry_name' => $industry->Industry_name ?? '',
                    'Industry_name' => $industry->Industry_name ?? '',
                    'client_id' => $industryClientIds,
                    'client_name' => implode(', ', $clientNames),
                    'client_names' => implode(', ', $clientNames),
                    'keywords' => $industry->Keywords ?? '',
                    'Keywords' => $industry->Keywords ?? ''
                ];
            }
        }
    
        // Return all matching records
        return response()->json([
            'clients' => $matchingClients,
            'competitors' => $matchingCompetitors,
            'industries' => $matchingIndustries
        ]);
    }

    // public function getCompitetorsFromClients(Request $request)
    // {
    //     // Get client IDs from POST request
    //      $clientsToMatch = $request->input('clientsData');

    //     // Ensure clientsToMatch is an array
    //     if (!is_array($clientsToMatch)) {
    //         $clientsToMatch = explode(',', $clientsToMatch);
    //     }

    //     $allData = []; // Modified to hold both competitor and industry data

    //     foreach ($clientsToMatch as $clientID) {
    //         $clientID = trim($clientID); // Ensure there are no surrounding spaces

    //         $competitorsData = DB::table('competitor')
    //         ->join('client', 'competitor.client_id', '=', 'client.client_id')
    //         ->select('competitor.*', 'client.client_name')
    //         ->whereIn('competitor.client_id', $clientsToMatch)
    //         ->get();
    //         $allIndustriesData = Industry_model::whereRaw('FIND_IN_SET(?, client_id)', [$clientID])->get();

    //         foreach ($competitorsData as $competitor) {
    //             foreach ($allIndustriesData as $industry) {
    //                 $allData[] = [
    //                     'competitor_name' => $competitor->Competitor_name,
    //                     'competitor_id' => $competitor->competitor_id,
    //                     'client_name' => $competitor->client_name,
    //                     'client_id' => $competitor->client_id,
    //                     'industry_id' => $industry->Industry_id,
    //                     'industry_name' => $industry->Industry_name,
    //                 ];
    //             }
    //         }
    //     }

    //     // Return JSON response
    //     return response()->json($allData);
    // }

    public function getCompitetorsFromClients(Request $request)
    {
        // Get client IDs from POST
        $clientsToMatch = $request->input('clientsData');

        if (!is_array($clientsToMatch)) {
            $clientsToMatch = explode(',', $clientsToMatch);
        }

        $clientsToMatch = array_map('trim', $clientsToMatch);

        $allData = [];

        foreach ($clientsToMatch as $clientID) {

            // Get competitors for this client only
            $competitors = DB::table('competitor')
                ->join('client', 'competitor.client_id', '=', 'client.client_id')
                ->select('competitor.*', 'client.client_name')
                ->where('competitor.client_id', $clientID)
                ->get();

            // ❌ If no competitors → completely skip this client
            if ($competitors->isEmpty()) {
                continue;
            }

            // Get industries for this client only
            $industries = Industry_model::whereRaw('FIND_IN_SET(?, client_id)', [$clientID])
                ->get();

            // Combine competitors × industries
            foreach ($competitors as $c) {
                foreach ($industries as $i) {
                    $allData[] = [
                        'competitor_name' => $c->Competitor_name,
                        'competitor_id'   => $c->competitor_id,
                        'client_name'     => $c->client_name,
                        'client_id'       => $c->client_id,
                        'industry_id'     => $i->Industry_id,
                        'industry_name'   => $i->Industry_name,
                    ];
                }
            }
        }

        return response()->json($allData);
    }

    public function getEditionAndJournalist(Request $request)
    {
        $publication = $request->input('publication');
        
        // Fetch editions
        $get_edition = DB::table('edition')
            ->where('MediaOutletId', $publication)
            ->select('gidEdition', 'Edition')
            ->get();
        
        // Fetch journalists
        $get_journalist = DB::table('journalist')
            ->where('gigMediaOutlet', $publication)
            ->select('gidJournalist', 'Journalist')
            ->get();
        
        // Generate options for editions
        $edition_options = '<option value="">Select Edition</option>';
        foreach ($get_edition as $value) {
            $edition_options .= '<option value="' . $value->gidEdition . '">' . $value->Edition . '</option>';
        }
        
        // Generate options for journalists
        $journalist_options = '<option value="">Select Journalist</option>';
        foreach ($get_journalist as $value) {
            $journalist_options .= '<option value="' . $value->gidJournalist . '">' . $value->Journalist . '</option>';
        }
        
        return response()->json(['edition_options' => $edition_options, 'journalist_options' => $journalist_options]);
    }
    
    public function processImage(Request $request)
    {
        // Get the image data from the request
        $imageData = $request->input('image');

        // Validate the request
        if (!$imageData) {
            return response()->json(['error' => 'No image data provided'], 400);
        }

        // Define your Google Vision API endpoint and API key
        $apiKey = 'AIzaSyBjnr10MeuuR2VECFkJvZB6jDZIkSzljCA';
        $url = "https://vision.googleapis.com/v1/images:annotate?key={$apiKey}";

        // Prepare the data for the API request
        $data = [
            'requests' => [
                [
                    'image' => [
                        'content' => $imageData
                    ],
                    'features' => [
                        [
                            'type' => 'TEXT_DETECTION'
                        ]
                    ]
                ]
            ]
        ];

        // Make the API request
        $response = \Http::post($url, $data);

        return $response->json();
    }
	
public function store(Request $request)
{
    // Validate the form data
    $request->validate([
        'media_type' => 'required|string',
        'publication' => 'required|string',
        'edition' => 'required|string',
        'journalist_name' => 'nullable|string',
        'author' => [
            'nullable',
            'string',
            function ($attribute, $value, $fail) use ($request) {
                if (empty($request->input('journalist_name')) && empty($value)) {
                    $fail('The author field is required when journalist name is not provided.');
                }
            },
        ],
        'NewsPosition' => 'required|string',
        //'NewsCity' => 'required|string|max:45',
        'headline' => 'required|string',
        'Summary' => 'required|string',
    ]);

    // Gather inputs
    $index_no = $request->input('index');
    $media_type = $request->input('media_type');
    $publication = $request->input('publication');
    $edition = $request->input('edition');
    $SupplementId = $request->input('SupplementId');
    $journalist_name = $request->input('journalist_name');
    $author = $request->input('author');
    $NewsPosition = $request->input('NewsPosition');
    $NewsCity = $request->input('NewsCity') ?: '';  // Default to empty string if not provided
    $headline = $request->input('headline');
    $Summary = $request->input('Summary');
    $website_url = $request->input('website_url');
    $publication_date = $request->input('publication_date');
    
    $allKeys = [];
    $allClients = [];
    $totalSize = 0;
    $category = "";

    // Process inputs related to size, categories, and assignments
    for ($i = 1; $i <= $index_no; $i++) {
        $getKeys = $request->input('getKeys' . $i);
        $getClient = $request->input('getclient' . $i) ?: [];
        if (!is_array($getClient)) {
            $getClient = array_filter(explode(',', (string)$getClient));
        }
        $companyHidden = array_filter(explode(',', (string)$request->input('company' . $i)));
        $allClients = array_merge($allClients, $getClient, $companyHidden);

        // Include client_id for any selected competitors
        $getComp = $request->input('getcompetitor' . $i) ?: [];
        if (!is_array($getComp)) {
            $getComp = array_filter(explode(',', (string)$getComp));
        }
        $compHidden = array_filter(explode(',', (string)$request->input('competitor' . $i)));
        $compIds = array_unique(array_filter(array_merge($getComp, $compHidden)));
        if (!empty($compIds)) {
            $compClientIds = DB::table('competitor')->whereIn('competitor_id', $compIds)->pluck('client_id')->toArray();
            $allClients = array_merge($allClients, $compClientIds);
        }

        // Include client_id for any selected industries
        $getInd = $request->input('getindustry' . $i) ?: [];
        if (!is_array($getInd)) {
            $getInd = array_filter(explode(',', (string)$getInd));
        }
        $indHidden = array_filter(explode(',', (string)$request->input('industry' . $i)));
        $indIds = array_unique(array_filter(array_merge($getInd, $indHidden)));
        if (!empty($indIds)) {
            $indClientRows = DB::table('industry')->whereIn('Industry_id', $indIds)->pluck('client_id')->toArray();
            foreach ($indClientRows as $icRow) {
                if (!empty($icRow)) {
                    $allClients = array_merge($allClients, explode(',', (string)$icRow));
                }
            }
        }

        $pageNo = $request->input('page_no' . $i);
        $height = $request->input('height' . $i);
        $width = $request->input('width' . $i);

        $size = $height * $width;

        if ($pageNo == 1) {
            $totalSize = $size;
        } else {
            $totalSize += $size;
        }

        // Set category based on total size
        if ($totalSize > 1000) {
            $category = 'Large';
        } elseif ($totalSize >= 500 && $totalSize <= 1000) {
            $category = 'Medium';
        } else {
            $category = 'Small';
        }

        // Merge keys
        if (is_array($getKeys)) {
            $allKeys = array_merge($allKeys, $getKeys);
        }
    }

    // Ensure keys and clients are unique and clean
    $allKeys = array_values(array_unique(array_filter($allKeys)));
    $allClients = array_values(array_unique(array_filter(array_map('trim', $allClients))));

    $getKeysString = implode(',', $allKeys);
    $getClientsString = implode(',', $allClients);    
    
    // Start database transaction
    DB::beginTransaction();

    try {
        // Insert into news_upload table
        $newsUpload = NewsUpload_Model::create([
            'media_type_id' => $media_type,
            'publication_id' => $publication,
            'edition_id' => $edition,
            'supplement_id' => $SupplementId,
            'publication_date' => $publication_date,
            'journalist_id' => $journalist_name,
            'author' => $author,
            'news_position' => $NewsPosition,
            'news_city_id' => $NewsCity,
            'head_line' => $headline,
            'summary' => $Summary,
            'is_send' => 0,
            'keywords' => $getKeysString,
            'company' => $getClientsString,
            'sizeofArticle' => $totalSize,
            'category' => $category,
            'website_url' => $website_url
        ]);

        // Get news details id
        $newsDetailsId = $newsUpload->news_details_id;

        if ($newsDetailsId) {
            // Insert into client_competetor_industry table
            for ($i = 1; $i <= $index_no; $i++) {
                $clientInput = $request->input('getclient' . $i) ?: [];
                if (!is_array($clientInput)) {
                    $clientInput = array_filter(explode(',', (string)$clientInput));
                }
                $companyHidden = array_filter(explode(',', (string)$request->input('company' . $i)));
                $selectedCompanyIds = array_unique(array_filter(array_map('trim', array_merge($clientInput, $companyHidden))));

                $compInput = $request->input('getcompetitor' . $i) ?: [];
                if (!is_array($compInput)) {
                    $compInput = array_filter(explode(',', (string)$compInput));
                }
                $compHidden = array_filter(explode(',', (string)$request->input('competitor' . $i)));
                $selectedCompIds = array_unique(array_filter(array_map('trim', array_merge($compInput, $compHidden))));

                $indInput = $request->input('getindustry' . $i) ?: [];
                if (!is_array($indInput)) {
                    $indInput = array_filter(explode(',', (string)$indInput));
                }
                $indHidden = array_filter(explode(',', (string)$request->input('industry' . $i)));
                $selectedIndIds = array_unique(array_filter(array_map('trim', array_merge($indInput, $indHidden))));

                // 1. Insert selected companies
                foreach ($selectedCompanyIds as $cid) {
                    client_competetor_industry::create([
                        'news_details_id' => $newsDetailsId,
                        'company_id' => $cid,
                        'competitor_id' => null,
                        'Industry_id' => null,
                    ]);
                }

                // 2. Insert selected competitors with their owning client_id
                foreach ($selectedCompIds as $compId) {
                    $compRow = DB::table('competitor')->where('competitor_id', $compId)->first();
                    $compClientId = $compRow ? $compRow->client_id : null;
                    client_competetor_industry::create([
                        'news_details_id' => $newsDetailsId,
                        'company_id' => $compClientId,
                        'competitor_id' => $compId,
                        'Industry_id' => null,
                    ]);
                }

                // 3. Insert selected industries with their owning client_id(s)
                foreach ($selectedIndIds as $indId) {
                    $indRow = DB::table('industry')->where('Industry_id', $indId)->first();
                    $indClientIds = (!empty($indRow) && !empty($indRow->client_id)) ? explode(',', (string)$indRow->client_id) : [null];
                    foreach ($indClientIds as $indCid) {
                        client_competetor_industry::create([
                            'news_details_id' => $newsDetailsId,
                            'company_id' => !empty($indCid) ? trim($indCid) : null,
                            'competitor_id' => null,
                            'Industry_id' => $indId,
                        ]);
                    }
                }
            }

            // Insert into news_artical_model table
            for ($i = 1; $i <= $index_no; $i++) {
                $editor = $request->input('editor' . $i);
                $pageNo = $request->input('page_no' . $i);
                $image_id = $request->input('image_id' . $i);
                $height = $request->input('height' . $i);
                $width = $request->input('width' . $i);

                news_artical_model::create([
                    'news_details_id' => $newsDetailsId,
                    'news_artical' => $editor,
                    'page_no' => $pageNo,
                    'artical_images_id' => $image_id,
                    'image_height' => $height,
                    'image_width' => $width,
                    'create_at' => now()
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Success message
            return redirect()->back()->with('success', 'News uploaded successfully.');
        } else {
            // Rollback if no newsDetailsId
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to upload news.');
        }
    } catch (\Exception $e) {
        // Rollback in case of any exception
        DB::rollBack();

        // Log the exception
        Log::error('Error uploading news: ' . $e->getMessage());

        // Set error message with exception details
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

    public function store10012025(Request $request)
{
    // Validate the form data
    $request->validate([
        'media_type' => 'required|string|max:255',
        'publication' => 'required|string|max:45',
        'edition' => 'required|string|max:45',
        'journalist_name' => 'nullable|string|max:500',
        'author' => [
            'nullable',
            'string',
            'max:500',
            function ($attribute, $value, $fail) use ($request) {
                if (empty($request->input('journalist_name')) && empty($value)) {
                    $fail('The author field is required when journalist name is not provided.');
                }
            },
        ],
        'NewsPosition' => 'required|string|max:45',
        //'NewsCity' => 'required|string|max:45',
        'headline' => 'required|string|max:255',
        'Summary' => 'required|string|max:500',
    ]);

    // Debugging
    $index_no = $request->input('index');
    $media_type = $request->input('media_type');
    $publication = $request->input('publication');
    $edition = $request->input('edition');
    $SupplementId = $request->input('SupplementId');
    $journalist_name = $request->input('journalist_name');
    $author = $request->input('author');
    $NewsPosition = $request->input('NewsPosition');
    if (!empty($request->input('NewsCity'))) {
        $NewsCity = $request->input('NewsCity');  // If 'NewsCity' input is present, assign its value
    } else {
        $NewsCity = "";  // If 'NewsCity' input is not present, assign an empty string
    }
    $headline = $request->input('headline');
    $Summary = $request->input('Summary');
    $website_url = $request->input('website_url');
    
    $allKeys = [];
    $allClients = [];
    $totalSize = 0;
	$category="";
    for ($i = 1; $i <= $index_no; $i++) {
        $getKeys = $request->input('getKeys' . $i);
        $getClient = $request->input('getclient' . $i);

        $pageNo = $request->input('page_no' . $i);
        $height = $request->input('height' . $i);
        $width = $request->input('width' . $i);

        $size = $height * $width;

        if ($pageNo == 1) {
            $totalSize = $size;
        } else {
            $totalSize += $size;
        }

        if ($totalSize > 1000) {
            $category = 'Large';
        } elseif ($totalSize >= 500 && $totalSize <= 1000) {
            $category = 'Medium';
        } else {
            $category = 'Small';
        }

        if (is_array($getKeys)) {
            $allKeys = array_merge($allKeys, $getKeys);
        }

        if (is_array($getClient)) {
            $allClients = array_merge($allClients, $getClient);
        }
    }

    $allKeys = array_unique($allKeys);
    $allClients = array_unique($allClients);

    $getKeysString = implode(',', $allKeys);
    $getClientsString = implode(',', $allClients);    
    
    // Perform insert
    try {
        $newsUpload = NewsUpload_Model::create([
            'media_type_id' => $media_type,
            'publication_id' => $publication,
            'edition_id' => $edition,
            'supplement_id' => $SupplementId,
            'journalist_id' => $journalist_name,
            'author' => $author,
            'news_position' => $NewsPosition,
            'news_city_id' => $NewsCity,
            'head_line' => $headline,
            'summary' => $Summary,
            'is_send' => 0,
            'keywords' => $getKeysString,
            'company' => $getClientsString,
            'sizeofArticle' => $totalSize,
            'category' => $category,
            'website_url' => $website_url
        ]);
        $newsDetailsId = $newsUpload->news_details_id;

        if ($newsDetailsId) {
            for ($i = 1; $i <= $index_no; $i++) {
                $get_company_data_id = array_filter(explode(',', $request->input('company' . $i)));
                $get_competitor_data_id = array_filter(explode(',', $request->input('competitor' . $i)));
                $get_industry_data_id = array_filter(explode(',', $request->input('industry' . $i)));
        
                $max_length = max(count($get_company_data_id), count($get_competitor_data_id), count($get_industry_data_id));
        
                for ($j = 0; $j < $max_length; $j++) {
                    // Debugging: Log the data to be inserted
                    Log::info('Inserting data into client_competetor_industry', [
                        'news_details_id' => $newsDetailsId,
                        'company_id' => $get_company_data_id[$j] ?? null,
                        'competitor_id' => $get_competitor_data_id[$j] ?? null,
                        'Industry_id' => $get_industry_data_id[$j] ?? null,
                    ]);
        
                    client_competetor_industry::create([
                        'news_details_id' => $newsDetailsId,
                        'company_id' => $get_company_data_id[$j] ?? null,
                        'competitor_id' => $get_competitor_data_id[$j] ?? null,
                        'Industry_id' => $get_industry_data_id[$j] ?? null,
                    ]);
                }
            }

            for ($i = 1; $i <= $index_no; $i++) {
                $editor = $request->input('editor' . $i);
                $pageNo = $request->input('page_no' . $i);
                $image_id = $request->input('image_id' . $i);
                $height = $request->input('height' . $i);
                $width = $request->input('width' . $i);

                news_artical_model::create([
                    'news_details_id' => $newsDetailsId,
                    'news_artical' => $editor,
                    'page_no' => $pageNo,
                    'artical_images_id' => $image_id,
                    'image_height' => $height,
                    'image_width' => $width,
                    'create_at' => now()
                ]);
            }

            // Set success message
            return redirect()->back()->with('success', 'News uploaded successfully.');
        } else {
            // Set error message
            return redirect()->back()->with('error', 'Failed to upload news.');
        }
    } catch (\Exception $e) {
        // Set error message with exception details
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}
}
