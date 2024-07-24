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
class NewsUpload extends Controller
{
    public function index(){
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
        return view('news_upload', compact('media_type', 'get_agency', 'news_city','getKeywords','get_clients'));

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
        $description = $request->input('description');
        
        // Get the keywords from your model
        $clientModel = new Client_Model();
        $keywords = $clientModel->getKeywords();
        
        $matched_keywords = [];
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword); // Trim each individual keyword
            if (stripos($description, $keyword) !== false) { // Case-insensitive comparison
                // If the keyword is found in the description, add it to the matched keywords array
                $matched_keywords[] = $keyword;
            }
        }
        // Return the matched keywords as a JSON response
        return response()->json($matched_keywords);
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
    
        // Return matching client IDs as a comma-separated string
        return response()->json($matchingClients);
    }

    public function getCompitetorsFromClients(Request $request)
    {
        // Get client IDs from POST request
         $clientsToMatch = $request->input('clientsData');

        // Ensure clientsToMatch is an array
        if (!is_array($clientsToMatch)) {
            $clientsToMatch = explode(',', $clientsToMatch);
        }

        $allData = []; // Modified to hold both competitor and industry data

        foreach ($clientsToMatch as $clientID) {
            $clientID = trim($clientID); // Ensure there are no surrounding spaces

            $competitorsData = DB::table('competitor')
            ->join('client', 'competitor.client_id', '=', 'client.client_id')
            ->select('competitor.*', 'client.client_name')
            ->whereIn('competitor.client_id', $clientsToMatch)
            ->get();
            $allIndustriesData = Industry_model::whereRaw('FIND_IN_SET(?, client_id)', [$clientID])->get();

            foreach ($competitorsData as $competitor) {
                foreach ($allIndustriesData as $industry) {
                    $allData[] = [
                        'competitor_name' => $competitor->Competitor_name,
                        'competitor_id' => $competitor->competitor_id,
                        'client_name' => $competitor->client_name,
                        'client_id' => $competitor->client_id,
                        'industry_id' => $industry->Industry_id,
                        'industry_name' => $industry->Industry_name,
                    ];
                }
            }
        }

        // Return JSON response
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
            'media_type' => 'required|string|max:255',
            'publication' => 'required|string|max:45',
            'edition' => 'required|string|max:45',
            'SupplementId' => 'required|string|max:45',
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
            'NewsCity' => 'required|string|max:45',
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
        $NewsCity = $request->input('NewsCity');
        $headline = $request->input('headline');
        $Summary = $request->input('Summary');
        $website_url = $request->input('website_url');
        
        $allKeys = [];
        $allClients = [];
        $totalSize = 0;
    
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
        $newsUpload =  NewsUpload_Model::create([
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
        $insertedId = $newsUpload->news_details_id;
    }
}
