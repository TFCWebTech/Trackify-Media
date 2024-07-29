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
                    ->whereIn('client_id', $clientIds)
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

    
    public function newsLatter($client_id)
    {
        $client = Client_Model::find($client_id);

        if (!$client) {
            abort(404, 'Client not found');
        }

        $details = $client->toArray();
        $get_client_details = $this->getClientTemplateDetails($client_id);
        // echo '<pre>';
        // print_r($details);
        // echo '</pre>';
    
        return view('newsLatter', compact('details', 'get_client_details'));
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

}
