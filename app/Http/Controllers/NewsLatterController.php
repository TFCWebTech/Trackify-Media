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
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewsMails;
use App\Mail\SendNewsMailsWithTemplate;

class NewsLatterController extends Controller
{
    public function CompanyNewsLetterList()
    {
        $Company = DB::table('client')
        ->where('client_type', 'Company')
        ->select('*')   
        ->get();    
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
            'get_news_details' => $this->getNewsDetails($client_id),
            'get_comp_data' => $this->getCompData($client_id),
            'get_industry_data' => $this->getIndustryData($client_id)
        ];
    
        if (empty($get_client_details) || empty($get_client_details[0]['client_id'])) {
            return view('defult_news_letter', $get_news_data);
        } else {
            return view('newsLatter', compact('details', 'get_client_details'));
        }
    }

    private function getClientTemplateDetails($client_id)
    {
        $templates = MailTemplate_Model::where('client_id', $client_id)
            ->get();
        foreach ($templates as &$template) {
            $template->get_quick_links = $this->getQuickLinks($template->mail_template_id);
            $template->client_news = $this->getNewsDetails($client_id);
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
            DB::raw('(SELECT COUNT(na.news_artical_id) FROM news_artical as na WHERE na.news_details_id = news_details.news_details_id) as page_count')
        ])
        ->distinct()
        ->leftJoin('mediaoutlet', 'news_details.publication_id', '=', 'mediaoutlet.gidMediaOutlet')
        ->leftJoin('edition', 'news_details.edition_id', '=', 'edition.gidEdition')
        ->leftJoin('supplements', 'news_details.supplement_id', '=', 'supplements.gidSupplement')
        ->leftJoin('journalist', 'news_details.journalist_id', '=', 'journalist.gidJournalist')
        ->leftJoin('Agency', 'news_details.journalist_id', '=', 'Agency.gidAgency')
        ->whereDate('news_details.create_at', $date)
        ->where('is_send', 0)
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
            $competitor->news = $this->getCompNewsByKey($competitor->Keywords, $client_id);
            $outArr[] = $competitor;
        }

        return $outArr;
    }

    public function getIndustryData($client_id)
    {
        $industries = Industry_model::whereRaw("FIND_IN_SET(?, client_id) > 0", [$client_id])->get();
        $outArr = [];
        
        foreach ($industries as $industry) {
            $industry->news = $this->getCompNewsByKey($industry->Keywords, $client_id);
            $outArr[] = $industry;
        }

        return $outArr;
    }

    public function getCompNewsByKey($keywords, $client_id)
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
            DB::raw('(SELECT COUNT(na.news_artical_id) FROM news_artical na WHERE na.news_details_id = news_details.news_details_id) as page_count')
        ])
        ->distinct()
        ->leftJoin('mediaoutlet', 'news_details.publication_id', '=', 'mediaoutlet.gidMediaOutlet')
        ->leftJoin('edition', 'news_details.edition_id', '=', 'edition.gidEdition')
        ->leftJoin('supplements', 'news_details.supplement_id', '=', 'supplements.gidSupplement')
        ->leftJoin('journalist', 'news_details.journalist_id', '=', 'journalist.gidJournalist')
        ->leftJoin('Agency', 'news_details.journalist_id', '=', 'Agency.gidAgency')
        ->whereDate('news_details.create_at', $date)
        ->where('is_send', 0)
        ->where(function($query) use ($client_id) {
            $query->whereRaw("NOT FIND_IN_SET(?, company)", [$client_id]);
        })
        ->where(function($query) use ($keywordsArray) {
            foreach ($keywordsArray as $keyword) {
                $keyword = trim($keyword);
                $query->orWhereRaw("FIND_IN_SET(?, keywords) > 0", [$keyword]);
            }
        })
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
    
        $get_news_details = $this->getNewsDetails($client_id);
        $news_ids = array_column($get_news_details, 'news_details_id'); // Extract news IDs
    
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
    
            \DB::table('news_details')
                ->whereIn('news_details_id', $news_ids)
                ->update([
                    'is_send' => 1,
                    'client_id' => $client_ids // Update the company column
                ]);
    
            session()->flash('success', 'Emails sent successfully.');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while sending emails.');
            return response()->json(['success' => false, 'message' => 'An error occurred while sending emails.'], 500);
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
    $get_news_details = $this->getNewsDetails($client_id);
    $news_ids = array_column($get_news_details, 'news_details_id'); // Extract news IDs

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

        // Update news details in the database
        \DB::table('news_details')
            ->whereIn('news_details_id', $news_ids)
            ->update([
                'is_send' => 1,
                'client_id' => $client_ids // Update the client ID
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
}
