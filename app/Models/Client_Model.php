<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client_Model extends Model
{
    use HasFactory;
    protected $table = 'client';
    protected $primaryKey = 'client_id';
    public $timestamps = false; // Disable Laravel's default timestamps

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
        
        // Remove duplicates from the combined keywords array
        $all_keywords = array_unique($all_keywords);
        
        // Return the combined and unique keywords array
        return $all_keywords;
    }

    public function getClients()
    {
        return $this->select('*')
        ->get()
        ->toArray();
    }
    protected $fillable = [
        'client_name',
        'client_keywords',
        'cilent_status',
        'create_at',
        'sector_id',
        'client_type',
    ];
    public function industries()
    {
        return $this->hasMany(Industry_model::class, 'client_id', 'client_id');
    }
}
