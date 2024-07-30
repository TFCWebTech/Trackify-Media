<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\NewsUpload_Model;
class NewsArtical extends Controller
{
    public function index($news_details_id)
    {
        $newsDetail = NewsUpload_Model::with([
            'mediaOutlet',
            'edition',
            'supplement',
            'journalist',
            'agency',
            'newsArticles.articleImages'
        ])->where('news_details_id', $news_details_id)->first();

        if ($newsDetail) {
            $newsDetail = $newsDetail->toArray();
        } else {
            $newsDetail = [];
        }
        // echo '<pre>';
        // print_r($newsDetail);
        // echo '</pre>';
        return view('news_article', compact('newsDetail'));
    }
}
