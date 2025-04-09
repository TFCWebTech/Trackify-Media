<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client_Model extends Model
{
    use HasFactory;
    protected $table = 'client';
    protected $primaryKey = 'client_id';
    public $timestamps = false; 

    public function getKeywords()
    {
        // Retrieve all client_keywords from the table
        $clients = $this->all();
        
        $all_keywords = [];

        foreach ($clients as $client) {
            // Check if client_keywords exists and is not null
            if (!empty($client->client_keywords)) {
                // Split client_keywords by commas
                $keywords = explode(',', $client->client_keywords);
                
                // Trim each keyword to remove leading/trailing whitespace
                $keywords = array_map('trim', $keywords);
                
                // Merge the keywords into the all_keywords array
                $all_keywords = array_merge($all_keywords, $keywords);
            }
        }
        $competitors = DB::table('competitor')->get(); // You could optimize with pluck() or other methods for large sets

        foreach ($competitors as $competitor) {
            // Check if competitor_keywords exists and is not null
            if (!empty($competitor->Keywords)) {
                // Split competitor keywords by commas and trim each keyword
                $keywords = explode(',', $competitor->Keywords); // Make sure it's the correct column name
                $keywords = array_map('trim', $keywords);
                
                // Merge the keywords into the all_keywords array
                $all_keywords = array_merge($all_keywords, $keywords);
            }
        }

        $industrys = DB::table('industry')->get(); // You could optimize with pluck() or other methods for large sets

        foreach ($industrys as $industry) {
            // Check if competitor_keywords exists and is not null
            if (!empty($competitor->Keywords)) {
                // Split competitor keywords by commas and trim each keyword
                $keywords = explode(',', $competitor->Keywords); // Make sure it's the correct column name
                $keywords = array_map('trim', $keywords);
                
                // Merge the keywords into the all_keywords array
                $all_keywords = array_merge($all_keywords, $keywords);
            }
        }

        // Remove duplicates from the combined keywords array
        $all_keywords = array_unique($all_keywords);
        //print_r($all_keywords);die;
        // Return the combined and unique keywords array
        return $all_keywords;
    }

    public function getClients()
    {
        return $this->select('*')
        ->get()
        
        ->toArray();
    }
    public function getClients1()
    {
        // Query builder with joins to fetch data from client, competitor, and industry tables
        $clients = DB::table('client')
            ->join('competitor', 'client.client_id', '=', 'competitor.client_id')
            ->join('industry', 'client.client_id', '=', 'industry.client_id')
            ->select('client.*', 'competitor.Keywords as competitor_Keywords', 'industry.Keywords as industry_keywords')  // Select fields from all three tables
            ->get();
    
        return $clients->toArray();
    }
    protected $fillable = [
        'client_name',
        'email',
        'report_service',
        'client_keywords',
        'cilent_status',
        'create_at',
        'sector_id',
        'client_type',
        'clients',
        'token',
    ];
   
    public function industries()
    {
        return $this->hasMany(Industry_model::class, 'client_id', 'client_id');
    }
    public static function getClientsForEmail()
    {
        return self::all()->toArray();
    }
}
