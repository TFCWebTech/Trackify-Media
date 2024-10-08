<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class NewsUpload_Model extends Model
{
    use HasFactory;
    
    protected $table = 'news_details'; // Ensure the correct table name
    protected $primaryKey = 'news_details_id';
    protected $guarded = [];
    public $timestamps = false; // Disable timestamps

    protected $fillable = [
        'media_type_id',
        'publication_id',
        'edition_id',
        'supplement_id',
        'journalist_id',
        'author',
        'news_position',
        'news_city_id',
        'category',
        'head_line',
        'summary',
        'is_send',
        'keywords',
        'company',
        'sizeofArticle',
        'website_url'
    ];

    public function mediaOutlet()
    {
        return $this->belongsTo(Publication_Model::class, 'publication_id', 'gidMediaOutlet');
    }

    public function edition()
    {
        return $this->belongsTo(ManageEditionsModel::class, 'edition_id', 'gidEdition');
    }

    public function supplement()
    {
        return $this->belongsTo(ManageSupplementModal::class, 'supplement_id', 'gidSupplement');
    }

    public function journalist()
    {
        return $this->belongsTo(managejournlmodel::class, 'journalist_id', 'gidJournalist');
    }

    public function agency()
    {
        return $this->belongsTo(Agency_Model::class, 'journalist_id', 'gidAgency');
    }

    public function newsArticles()
    {
        return $this->hasMany(news_artical_model::class, 'news_details_id', 'news_details_id');
    }
    // public function getKeywords()
    // {
    //     // Retrieve all client_keywords from the table
    //     $clients = $this->all();
        
    //     $all_keywords = [];

    //     foreach ($clients as $client) {
    //         // Check if client_keywords exists and is not null
    //         if (!empty($client->client_keywords)) {
    //             // Split client_keywords by commas
    //             $keywords = explode(',', $client->client_keywords);
                
    //             // Trim each keyword to remove leading/trailing whitespace
    //             $keywords = array_map('trim', $keywords);
                
    //             // Merge the keywords into the all_keywords array
    //             $all_keywords = array_merge($all_keywords, $keywords);
    //         }
    //     }
        
    //     // Remove duplicates from the combined keywords array
    //     $all_keywords = array_unique($all_keywords);
        
    //     // Return the combined and unique keywords array
    //     return $all_keywords;
    // }

    // public function getClients()
    // {
    //     return $this->select('*')
    //     ->get()
    //     ->toArray();
    // }


    
}
