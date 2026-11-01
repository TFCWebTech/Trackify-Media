<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Client_Model;
use App\Models\Competitor_Model;
use App\Models\Industry_model;
use App\Models\NewsUpload_Model;
use App\Models\MailTemplate_Model;
use App\Models\deleteNews;
use App\Models\ClientSentNews;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewsMails;
use App\Mail\SendNewsMailsWithTemplate;

class NewsLatterController extends Controller
{
    private function baseNewsQueryForClient(int $client_id)
    {
        return NewsUpload_Model::select([
            'news_details.*',
            'mediaoutlet.*',
            'edition.gidEdition',
            'edition.Edition',
            'supplements.gidSupplement',
            'supplements.Supplement',
            'journalist.gidJournalist',
            'journalist.Journalist',
            'agency.Agency',
            DB::raw('(SELECT na.page_no FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_no'),
            DB::raw('(SELECT COUNT(na.news_artical_id) FROM news_artical na WHERE na.news_details_id = news_details.news_details_id) as page_count'),
        ])
            ->distinct()
            ->leftJoin('mediaoutlet', 'news_details.publication_id', '=', 'mediaoutlet.gidMediaOutlet')
            ->leftJoin('edition', 'news_details.edition_id', '=', 'edition.gidEdition')
            ->leftJoin('supplements', 'news_details.supplement_id', '=', 'supplements.gidSupplement')
            ->leftJoin('journalist', 'news_details.journalist_id', '=', 'journalist.gidJournalist')
            ->leftJoin('agency', 'news_details.journalist_id', '=', 'agency.gidAgency')
            ->whereRaw('FIND_IN_SET(?, company)', [$client_id])
            ->whereRaw(
                'NOT EXISTS (SELECT 1 FROM client_sent_news csn WHERE csn.news_details_id = news_details.news_details_id AND csn.client_id = ?)',
                [$client_id]
            )
            ->whereRaw(
                'NOT EXISTS (SELECT 1 FROM delete_news dn WHERE dn.news_details_id = news_details.news_details_id AND dn.client_id = ?)',
                [$client_id]
            );
    }

    private function getNewsByAssignment(int $client_id, array $assignmentWhere): array
    {
        $query = $this->baseNewsQueryForClient($client_id)
            ->join('client_competetor_industry as cci', 'cci.news_details_id', '=', 'news_details.news_details_id');

        foreach ($assignmentWhere as $column => $value) {
            $query->where("cci.$column", $value);
        }

        return $query->get()->toArray();
    }

    public function CompanyNewsLetterList()
    {
        $Company = DB::table('client')
            ->where('client_type', 'Company')
            ->select('*')
            ->get();

        // Enrich with counts needed by `newsLatter_list` table.
        $today = date('Y-m-d');
        foreach ($Company as $company) {
            $company->email_count = DB::table('mail_send_logs')
                ->where('client_id', $company->client_id)
                ->whereDate('sent_date', $today)
                ->sum('emails_sent_count');

            $company->today_pending_news = DB::table('news_details')
                ->whereDate('create_at', $today)
                ->whereRaw('FIND_IN_SET(?, company) > 0', [$company->client_id])
                ->whereRaw(
                    'NOT EXISTS (SELECT 1 FROM client_sent_news csn WHERE csn.news_details_id = news_details.news_details_id AND csn.client_id = ?)',
                    [$company->client_id]
                )
                ->whereRaw(
                    'NOT EXISTS (SELECT 1 FROM delete_news dn WHERE dn.news_details_id = news_details.news_details_id AND dn.client_id = ?)',
                    [$company->client_id]
                )
                ->count();

            $company->today_sent_news = DB::table('client_sent_news')
                ->where('client_id', $company->client_id)
                ->whereDate('sent_date', $today)
                ->count();
        }

        return view('newsLatter_list', compact('Company'));
    }

    public function update(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'news_details_id' => 'required|integer',
            'client_id' => 'required|integer',
            'headline' => 'required|string',
            'summary' => 'required|string',
        ]);

        $clientIdString = $request->input('client_id');
        // Split the comma-separated string into an array
        $clientIds = explode(',', $clientIdString);
        // Find the news item based on provided IDs
        $news = NewsUpload_Model::where('news_details_id', $request->input('news_details_id'))
        ->where(function($query) use ($clientIds) {
            foreach ($clientIds as $clientId) {
                $query->orWhereRaw('FIND_IN_SET(?, company)', [$clientId]);
            }
        })
        ->first();

        // Debugging: Check if news was found
        if (!$news) {
            \Log::error('News not found with news_details_id: ' . $request->input('news_details_id') . ' and client_id: ' . $request->input('client_id'));
            return response()->json(['success' => false, 'message' => 'News not found.']);
        }
        // Update the news item
        $news->head_line = $request->input('headline');
        $news->summary = $request->input('summary');
        $news->save();
        // Return a success response
        return response()->json(['success' => true, 'message' => 'News updated successfully.']);
    }

    public function updateNewsofCompIndu(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'news_details_id' => 'required|integer',
            'client_id' => 'required|integer',
            'headline' => 'required|string',
            'summary' => 'required|string',
        ]);

        $clientIdString = $request->input('client_id');
        // Split the comma-separated string into an array
       
        $news = NewsUpload_Model::where('news_details_id', $request->input('news_details_id'))
        ->first();

        // Debugging: Check if news was found
        if (!$news) {
            \Log::error('News not found with news_details_id: ' . $request->input('news_details_id') . ' and client_id: ' . $request->input('client_id'));
            return response()->json(['success' => false, 'message' => 'News not found.']);
        }
        // Update the news item
        $news->head_line = $request->input('headline');
        $news->summary = $request->input('summary');
        $news->save();
        // Return a success response
        return response()->json(['success' => true, 'message' => 'News updated successfully.']);
    }

    public function deleteNews(Request $request)
    {
        $newsDetailsId = $request->input('news_details_id');
        $clientId = $request->input('client_id');
        $type = $request->input('type');
        
        if($type === 'delete'){
            $response = [
                'news_details_id' => $newsDetailsId,
                'client_id' => $clientId,
                'is_delete' => 1,
                'is_hide' => 0
            ];
    
            DeleteNews::create($response);
    
            return response()->json([
                'status' => 'success',
                'message' => 'News deleted successfully',
                'news_details_id' => $newsDetailsId
            ]);
        } elseif($type === 'hide'){
            $response = [
                'news_details_id' => $newsDetailsId,
                'client_id' => $clientId,
                'is_delete' => 0,
                'is_hide' => 1
            ];
    
            DeleteNews::create($response);
    
            return response()->json([
                'status' => 'success',
                'message' => 'News hidden successfully',
                'news_details_id' => $newsDetailsId
            ]);
        }
    }

    public function getEmail(Request $request)
    {
        $c_id = $request->input('client_id');
        $get_client_email = Client_Model::getClientsForEmail();
        $client_emails = [];
        $client_ids = [];

        foreach ($get_client_email as $client) {
            if (!empty($client['clients'])) {
                $clients_array = explode(',', $client['clients']);
                if (in_array($c_id, $clients_array)) {
                    $client_emails[] = ['client_email' => $client['email']];
                    $client_ids[] = $client['client_id'];
                }
            }
        }

        $client_ids = array_unique($client_ids);
        $response = [
            'emails' => $client_emails,
            'client_ids' => $client_ids, 
            'c_id' => $c_id
        ];

        return response()->json($response);
    }


    public function newsLatter($client_id)
    {
        $client = Client_Model::find($client_id);
    
        if (!$client) {
            abort(404, 'Client not found');
        }
    
        $details = $client->toArray();
        $get_client_details = $this->getClientTemplateDetails($client_id);
    
        $get_news_data = [
            'get_client_data' => $client->toArray(),
            //'get_news_details' => $this->getNewsDetails3($client_id),
            'get_news_details' => $this->getClientData($client_id),
            'get_comp_data' => $this->getCompData($client_id),
            'get_industry_data' => $this->getIndustryData($client_id)
        ];
    
        if (empty($get_client_details) || empty($get_client_details[0]['client_id'])) {
            return view('defult_news_letter', $get_news_data);
        } else {
           // echo "hh";die;
            return view('newsLatter', compact('details', 'get_client_details'));
        }
    }

    private function getClientTemplateDetails($client_id)
    {
        $templates = MailTemplate_Model::where('client_id', $client_id)
            ->get();
        foreach ($templates as &$template) {
            $template->get_quick_links = $this->getQuickLinks($template->mail_template_id);
			//$template->client_news = $this->getNewsDetails3($client_id);
            $template->client_news = $this->getClientData($client_id);
            $template->compititors_data = $this->getCompData($client_id);
            $template->industry_data = $this->getIndustryData($client_id);
        }
        return $templates->toArray();
    }

    private function getQuickLinks($mail_template_id)
    {
        $quick_links = DB::table('quick_links')
            ->where('mail_template_id', $mail_template_id) // Corrected line
            ->select('*')
            ->get();
    
        return $quick_links->toArray(); // Added toArray() to convert the collection to an array
    }
	 private function getClientNewsDetails($keywords,$client_id)
    {
        $date = date('Y-m-d');
        $keywordsArray = explode(',', $keywords);
        $newsDetails = NewsUpload_Model::select([
            'news_details.*',
            'mediaoutlet.*',
            'edition.gidEdition',
            'edition.Edition',
            'supplements.gidSupplement',
            'supplements.Supplement',
            'journalist.gidJournalist',
            'journalist.Journalist',
            'agency.Agency',
			DB::raw('(SELECT na.page_no FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_no'),
            DB::raw('(SELECT COUNT(na.news_artical_id) FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_count')
        ])
        ->distinct()
        ->leftJoin('mediaoutlet', 'news_details.publication_id', '=', 'mediaoutlet.gidMediaOutlet')
        ->leftJoin('edition', 'news_details.edition_id', '=', 'edition.gidEdition')
        ->leftJoin('supplements', 'news_details.supplement_id', '=', 'supplements.gidSupplement')
        ->leftJoin('journalist', 'news_details.journalist_id', '=', 'journalist.gidJournalist')
        ->leftJoin('agency', 'news_details.journalist_id', '=', 'agency.gidAgency')
        ->whereDate('news_details.create_at', $date)
        ->whereRaw(
            'NOT EXISTS (SELECT 1 FROM client_sent_news csn WHERE csn.news_details_id = news_details.news_details_id AND csn.client_id = ?)',
            [$client_id]
        )
        ->where(function($query) use ($client_id) {
            $query->where('news_details.company', 'LIKE', '%,' . $client_id . ',%')
                  ->orWhere('news_details.company', 'LIKE', $client_id . ',%')
                  ->orWhere('news_details.company', 'LIKE', '%,' . $client_id)
                  ->orWhere('news_details.company', '=', $client_id);
        })
        ->where(function($query) use ($keywordsArray) {
            foreach ($keywordsArray as $keyword) {
                $keyword = trim($keyword);
                $query->orWhereRaw("FIND_IN_SET(?, keywords) > 0", [$keyword]);
            }
        })
        ->whereRaw('NOT EXISTS (SELECT 1 FROM delete_news WHERE delete_news.news_details_id = news_details.news_details_id AND delete_news.client_id = ?)', [$client_id])
        ->get();

        return $newsDetails->toArray();
    }
    private function getNewsDetails($client_id)
    {
        $date = date('Y-m-d');

        $newsDetails = NewsUpload_Model::select([
            'news_details.*',
            'mediaoutlet.*',
            'edition.gidEdition',
            'edition.Edition',
            'supplements.gidSupplement',
            'supplements.Supplement',
            'journalist.gidJournalist',
            'journalist.Journalist',
            'agency.Agency',
			DB::raw('(SELECT na.page_no FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_no'),
            DB::raw('(SELECT COUNT(na.news_artical_id) FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_count')
        ])
        ->distinct()
        ->leftJoin('mediaoutlet', 'news_details.publication_id', '=', 'mediaoutlet.gidMediaOutlet')
        ->leftJoin('edition', 'news_details.edition_id', '=', 'edition.gidEdition')
        ->leftJoin('supplements', 'news_details.supplement_id', '=', 'supplements.gidSupplement')
        ->leftJoin('journalist', 'news_details.journalist_id', '=', 'journalist.gidJournalist')
        ->leftJoin('agency', 'news_details.journalist_id', '=', 'agency.gidAgency')
        ->whereDate('news_details.create_at', $date)
        ->whereRaw(
            'NOT EXISTS (SELECT 1 FROM client_sent_news csn WHERE csn.news_details_id = news_details.news_details_id AND csn.client_id = ?)',
            [$client_id]
        )
        ->where(function($query) use ($client_id) {
            $query->where('news_details.company', 'LIKE', '%,' . $client_id . ',%')
                  ->orWhere('news_details.company', 'LIKE', $client_id . ',%')
                  ->orWhere('news_details.company', 'LIKE', '%,' . $client_id)
                  ->orWhere('news_details.company', '=', $client_id);
        })
        ->whereRaw('NOT EXISTS (SELECT 1 FROM delete_news WHERE delete_news.news_details_id = news_details.news_details_id AND delete_news.client_id = ?)', [$client_id])
        ->get();

        return $newsDetails->toArray();
    }
	  private function getNewsDetails3($client_id)
    {
        $date = date('Y-m-d');

// Get news details
$newsDetails = NewsUpload_Model::select([
    'news_details.*',
    'mediaoutlet.*',
    'edition.gidEdition',
    'edition.Edition',
    'supplements.gidSupplement',
    'supplements.Supplement',
    'journalist.gidJournalist',
    'journalist.Journalist',
    'agency.Agency',
    DB::raw('(SELECT na.page_no FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_no'),
    DB::raw('(SELECT COUNT(na.news_artical_id) FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_count')
])
->distinct()
->leftJoin('mediaoutlet', 'news_details.publication_id', '=', 'mediaoutlet.gidMediaOutlet')
->leftJoin('edition', 'news_details.edition_id', '=', 'edition.gidEdition')
->leftJoin('supplements', 'news_details.supplement_id', '=', 'supplements.gidSupplement')
->leftJoin('journalist', 'news_details.journalist_id', '=', 'journalist.gidJournalist')
->leftJoin('agency', 'news_details.journalist_id', '=', 'agency.gidAgency')
->leftJoin('client', 'news_details.client_id', '=', 'client.client_id')
->whereDate('news_details.create_at', $date)
->whereRaw(
    'NOT EXISTS (SELECT 1 FROM client_sent_news csn WHERE csn.news_details_id = news_details.news_details_id AND csn.client_id = ?)',
    [$client_id]
)
->where(function($query) use ($client_id) {
    // Ensure we match client_id correctly in the comma-separated list
    $query->whereRaw('FIND_IN_SET(?, news_details.client_id)', [$client_id]);
})
//->whereIn('news_details.client_id', $client_id)
->whereRaw('NOT EXISTS (SELECT 1 FROM delete_news WHERE delete_news.news_details_id = news_details.news_details_id AND delete_news.client_id = ?)', [$client_id])
->get();

// Now loop over each news detail and process the keywords
$newsDetails->each(function($newsDetail) use ($client_id) {
    // Split the keywords in news_details
    $keywords = explode(',', $newsDetail->keywords);

    // Build the query to match keywords using LIKE or REGEXP
    $newsDetail->matchingClients = Client_Model::whereRaw('FIND_IN_SET(?, client_keywords)', [implode(',', $keywords)]) // Match using LIKE
        ->orWhere(function($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhereRaw('client.client_keywords LIKE ?', ['%' . trim($keyword) . '%']);
            }
        })
        ->get(); // or use any other query you prefer to get the matching clients
});

// Return the results
return $newsDetails->toArray();

    }  
	  private function getNewsDetails2($client_id)
    {
        $date = date('Y-m-d');

        $newsDetails = NewsUpload_Model::select([
            'news_details.*',
            'mediaoutlet.*',
            'edition.gidEdition',
            'edition.Edition',
            'supplements.gidSupplement',
            'supplements.Supplement',
            'journalist.gidJournalist',
            'journalist.Journalist',
            'agency.Agency',
			DB::raw('(SELECT na.page_no FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_no'),
            DB::raw('(SELECT COUNT(na.news_artical_id) FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_count')
        ])
        ->distinct()
        ->leftJoin('mediaoutlet', 'news_details.publication_id', '=', 'mediaoutlet.gidMediaOutlet')
        ->leftJoin('edition', 'news_details.edition_id', '=', 'edition.gidEdition')
        ->leftJoin('supplements', 'news_details.supplement_id', '=', 'supplements.gidSupplement')
        ->leftJoin('journalist', 'news_details.journalist_id', '=', 'journalist.gidJournalist')
        ->leftJoin('agency', 'news_details.journalist_id', '=', 'agency.gidAgency')
        ->whereDate('news_details.create_at', $date)
        ->whereRaw(
            'NOT EXISTS (SELECT 1 FROM client_sent_news csn WHERE csn.news_details_id = news_details.news_details_id AND csn.client_id = ?)',
            [$client_id]
        )
        ->where(function($query) use ($client_id) {
            $query->where('news_details.company', 'LIKE', '%,' . $client_id . ',%')
                  ->orWhere('news_details.company', 'LIKE', $client_id . ',%')
                  ->orWhere('news_details.company', 'LIKE', '%,' . $client_id)
                  ->orWhere('news_details.company', '=', $client_id);
        })
        ->whereRaw('NOT EXISTS (SELECT 1 FROM delete_news WHERE delete_news.news_details_id = news_details.news_details_id AND delete_news.client_id = ?)', [$client_id])
        ->get();

        return $newsDetails->toArray();
    }
    public function getCompData($client_id)
    {
        $competitors = Competitor_Model::where('client_id', $client_id)->get();
        $outArr = [];
        
        foreach ($competitors as $competitor) {
            $competitor->news = $this->getNewsByAssignment((int) $client_id, ['competitor_id' => (int) $competitor->competitor_id]);
            if (empty($competitor->news)) {
                $combinedKeys = trim(($competitor->Competitor_name ?? '') . ',' . ($competitor->Keywords ?? ''), ',');
                $competitor->news = $this->getCompNewsByKey($combinedKeys, $client_id);
            }
			$competitor->news2 = $this->getNewsDetails2($client_id);
            $outArr[] = $competitor;
        }

        return $outArr;
    }
	 public function getClientData($client_id)
    {
        $clients = Client_Model::where('client_id', $client_id)->get();
        $outArr = [];
        
        foreach ($clients as $client) {
            $client->news = $this->getNewsByAssignment((int) $client_id, ['company_id' => (int) $client_id]);
            if (empty($client->news)) {
                $combinedKeys = trim(($client->client_name ?? '') . ',' . ($client->client_keywords ?? ''), ',');
                $client->news = $this->getCompNewsByKey($combinedKeys, $client_id);
            }
			//$client->news = $this->getClientNewsDetails($client->client_keywords, $client_id);
            $outArr[] = $client;
        }
        //echo "<pre>";
        //print_r($outArr);die;
        return $outArr;
    }
    public function getIndustryData($client_id)
    {
        $industries = Industry_model::whereRaw("FIND_IN_SET(?, client_id) > 0", [$client_id])->get();
        $outArr = [];
        
        foreach ($industries as $industry) {
            $industry->news = $this->getNewsByAssignment((int) $client_id, ['Industry_id' => (int) $industry->Industry_id]);
            if (empty($industry->news)) {
                $combinedKeys = trim(($industry->Industry_name ?? '') . ',' . ($industry->Keywords ?? ''), ',');
                $industry->news = $this->getCompNewsByKey($combinedKeys, $client_id);
            }
			$industry->industry_new2 = $this->getNewsDetails2($client_id);
            $outArr[] = $industry;
        }

        return $outArr;
    }

    public function getCompNewsByKey($keywords, $client_id)
    {
        $keywordsArray = array_filter(array_map('trim', explode(',', (string)$keywords)));

        if (empty($keywordsArray)) {
            return [];
        }

        $newsDetails = NewsUpload_Model::select([
            'news_details.*',
            'mediaoutlet.*',
            'edition.gidEdition',
            'edition.Edition',
            'supplements.gidSupplement',
            'supplements.Supplement',
            'journalist.gidJournalist',
            'journalist.Journalist',
            'agency.Agency',
			DB::raw('(SELECT na.page_no FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id LIMIT 1) as page_no'),
            DB::raw('(SELECT COUNT(na.news_artical_id) FROM news_artical na WHERE na.news_details_id = news_details.news_details_id) as page_count')
        ])
        ->distinct()
        ->leftJoin('mediaoutlet', 'news_details.publication_id', '=', 'mediaoutlet.gidMediaOutlet')
        ->leftJoin('edition', 'news_details.edition_id', '=', 'edition.gidEdition')
        ->leftJoin('supplements', 'news_details.supplement_id', '=', 'supplements.gidSupplement')
        ->leftJoin('journalist', 'news_details.journalist_id', '=', 'journalist.gidJournalist')
        ->leftJoin('agency', 'news_details.journalist_id', '=', 'agency.gidAgency')
        // ->whereDate('news_details.create_at', $date)
        ->where(function($query) use ($client_id) {
            $query->whereRaw("FIND_IN_SET(?, company)", [$client_id]);
        })
        ->where(function($query) use ($keywordsArray) {
            foreach ($keywordsArray as $keyword) {
                $query->orWhereRaw("FIND_IN_SET(?, keywords) > 0", [$keyword])
                      ->orWhere('news_details.head_line', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('news_details.summary', 'LIKE', '%' . $keyword . '%');
            }
        })
        ->whereRaw(
            'NOT EXISTS (SELECT 1 FROM client_sent_news csn WHERE csn.news_details_id = news_details.news_details_id AND csn.client_id = ?)',
            [$client_id]
        )
        ->whereRaw('NOT EXISTS (SELECT 1 FROM delete_news dn WHERE dn.news_details_id = news_details.news_details_id AND dn.client_id = ?)', [$client_id])
        ->get();

        return $newsDetails->toArray();
    }

    //send news funcationality for with defult template
    public function sendEmail(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'client_ids' => 'required|string',
            'clientMails*' => 'required|array',
        ]);
    
        $client_id = $request->input('client_id');
        $client_ids = $request->input('client_ids'); // Keep as a string for update
        $client_ids_array = explode(',', $client_ids); // For sending emails
        $emails = [];
        $client = Client_Model::find($client_id);
    
        if (!$client) {
            return response()->json(['success' => false, 'message' => 'Client not found'], 404);
        }
    
        $get_news_details = $this->getClientData($client_id);
        $news_ids = $this->collectNewsIds(
            $get_news_details,
            $this->getCompData($client_id),
            $this->getIndustryData($client_id)
        );
    
        $get_news_data = [
            'get_client_data' => $client->toArray(),
            'get_news_details' => $get_news_details,
            'get_comp_data' => $this->getCompData($client_id),
            'get_industry_data' => $this->getIndustryData($client_id),
        ];
    
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'clientMails') === 0) {
                $emails = array_merge($emails, $value);
            }
        }
    
        try {
            foreach ($emails as $email) {
                Mail::to($email)->send(new SendNewsMails($client_id, $client_ids_array, $get_news_data));
            }
    
            $this->recordSentNewsForClient((int) $client_id, (string) $client_ids, $news_ids);
    
            \DB::table('mail_send_logs')->insert([
                'client_id' => $client_id,
                'emails_sent_count' => count($emails),
                'sent_date' => date('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            session()->flash('success', 'Emails sent successfully.');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while sending emails.');
            // return response()->json(['success' => false, 'message' => 'An error occurred while sending emails.'], 500);
            return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile()
    ], 500);
        }
    }

    public function sendEmailWithTemplate(Request $request)
{
    // Validate incoming request data
    $request->validate([
        'client_id' => 'required|integer',
        'client_ids' => 'required|string',
        'clientMails.*' => 'required|email', // Ensure each email is valid
    ]);

    $client_id = $request->input('client_id');
    $client_ids = $request->input('client_ids'); // Keep as a string for update
    $client_ids_array = explode(',', $client_ids); // Convert comma-separated IDs to array
    $emails = [];
    $client = Client_Model::find($client_id);

    if (!$client) {
        return response()->json(['success' => false, 'message' => 'Client not found'], 404);
    }

    // Fetch client and news details
    $details = $client->toArray();
    $get_client_details = json_decode(json_encode($this->getClientTemplateDetails($client_id)), true); // Convert to array
    $get_news_details = $this->getClientData($client_id);
    $news_ids = $this->collectNewsIds(
        $get_news_details,
        $this->getCompData($client_id),
        $this->getIndustryData($client_id)
    );

    foreach ($request->all() as $key => $value) {
        if (strpos($key, 'clientMails') === 0) {
            $emails = array_merge($emails, $value);
        }
    }

    try {
        // Send emails
        foreach ($emails as $email) {
            Mail::to($email)->send(new SendNewsMailsWithTemplate($client_id, $client_ids_array, $details, $get_client_details));
        }

        // Record sent status for this client and conditionally update news_details
        $this->recordSentNewsForClient((int) $client_id, (string) $client_ids, $news_ids);

        \DB::table('mail_send_logs')->insert([
            'client_id' => $client_id,
            'emails_sent_count' => count($emails),
            'sent_date' => date('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        session()->flash('success', 'Emails sent successfully.');
        return response()->json([
            'success' => true,
            'get_client_details' => $get_client_details // Include the client details in the response
        ]);
    } catch (\Exception $e) {
        \Log::error('Error sending emails: ' . $e->getMessage(), [
            'client_id' => $client_id,
            'client_ids' => $client_ids_array,
            'emails' => $emails,
            'details' => $details,
            'error_message' => $e->getMessage(), // Include the error message in the logs
        ]);
        return response()->json(['success' => false, 'message' => 'Error sending emails: ' . $e->getMessage()], 500);
    }
}

    private function collectNewsIds($clientData, $compData, $industryData): array
    {
        $ids = [];

        foreach ((array) $clientData as $row) {
            $newsList = is_array($row) ? ($row['news'] ?? []) : ($row->news ?? []);
            if (is_array($newsList)) {
                foreach ($newsList as $news) {
                    if (!empty($news['news_details_id'])) {
                        $ids[] = (int) $news['news_details_id'];
                    }
                }
            }
        }

        foreach ((array) $compData as $row) {
            $newsList = is_array($row) ? ($row['news'] ?? []) : ($row->news ?? []);
            if (is_array($newsList)) {
                foreach ($newsList as $news) {
                    if (!empty($news['news_details_id'])) {
                        $ids[] = (int) $news['news_details_id'];
                    }
                }
            }
        }

        foreach ((array) $industryData as $row) {
            $newsList = is_array($row) ? ($row['news'] ?? []) : ($row->news ?? []);
            if (is_array($newsList)) {
                foreach ($newsList as $news) {
                    if (!empty($news['news_details_id'])) {
                        $ids[] = (int) $news['news_details_id'];
                    }
                }
            }
        }

        $ids = array_values(array_unique($ids));
        return $ids;
    }

    private function recordSentNewsForClient(int $clientId, string $recipientClientIds, array $newsIds): void
    {
        $today = date('Y-m-d');
        foreach ($newsIds as $newsId) {
            DB::table('client_sent_news')->updateOrInsert(
                [
                    'news_details_id' => $newsId,
                    'client_id' => $clientId,
                ],
                [
                    'sent_date' => $today,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $newsRow = DB::table('news_details')->where('news_details_id', $newsId)->first();
            if ($newsRow) {
                $existingRecipients = !empty($newsRow->client_id) ? explode(',', $newsRow->client_id) : [];
                $newRecipients = array_filter(array_map('trim', explode(',', $recipientClientIds)));
                $mergedRecipients = implode(',', array_unique(array_filter(array_merge($existingRecipients, $newRecipients))));

                $updateData = ['client_id' => $mergedRecipients];

                if (!empty($newsRow->company)) {
                    $assignedClients = array_filter(array_map('trim', explode(',', $newsRow->company)));
                    $sentCount = DB::table('client_sent_news')
                        ->where('news_details_id', $newsId)
                        ->whereIn('client_id', $assignedClients)
                        ->count();
                    if ($sentCount >= count($assignedClients)) {
                        $updateData['is_send'] = 1;
                    }
                }

                DB::table('news_details')
                    ->where('news_details_id', $newsId)
                    ->update($updateData);
            }
        }
    }
}
