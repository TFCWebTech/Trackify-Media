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
        // Retrieve all clients from the table
        $clients = $this->all();
        
        $all_keywords = [];

        foreach ($clients as $client) {
            if (!empty($client->client_name)) {
                $all_keywords[] = trim($client->client_name);
            }
            // Check if client_keywords exists and is not null
            if (!empty($client->client_keywords)) {
                // Split client_keywords by commas
                $keywords = explode(',', $client->client_keywords);
                $keywords = array_map('trim', $keywords);
                $all_keywords = array_merge($all_keywords, $keywords);
            }
        }

        $competitors = DB::table('competitor')->get();

        foreach ($competitors as $competitor) {
            if (!empty($competitor->Competitor_name)) {
                $all_keywords[] = trim($competitor->Competitor_name);
            }
            // Check if competitor Keywords exists and is not null
            if (!empty($competitor->Keywords)) {
                $keywords = explode(',', $competitor->Keywords);
                $keywords = array_map('trim', $keywords);
                $all_keywords = array_merge($all_keywords, $keywords);
            }
        }

        $industrys = DB::table('industry')
            ->where(function($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            })
            ->get();

        foreach ($industrys as $industry) {
            if (!empty($industry->Industry_name)) {
                $all_keywords[] = trim($industry->Industry_name);
                $nameWords = preg_split('/[\s,\-\/]+/', trim($industry->Industry_name));
                if (count($nameWords) > 1) {
                    foreach ($nameWords as $nw) {
                        $nw = trim($nw);
                        if (mb_strlen($nw) >= 3 && !in_array(strtolower($nw), ['industry', 'industries', 'test', 'demo'])) {
                            $all_keywords[] = $nw;
                        }
                    }
                }
            }
            // Check if industry Keywords exists and is not null
            if (!empty($industry->Keywords)) {
                $keywords = explode(',', $industry->Keywords);
                foreach ($keywords as $kw) {
                    $kw = trim($kw);
                    if (empty($kw)) continue;
                    $all_keywords[] = $kw;
                    $words = preg_split('/[\s\-\/]+/', $kw);
                    if (count($words) > 1) {
                        foreach ($words as $w) {
                            $w = trim($w);
                            if (mb_strlen($w) >= 3 && !in_array(strtolower($w), ['industry', 'industries', 'with', 'from', 'that', 'this', 'have', 'more', 'some', 'than', 'and', 'the', 'for'])) {
                                $all_keywords[] = $w;
                            }
                        }
                    }
                }
            }
        }

        // Remove duplicates and empty or 1-character entries (such as stray 'a') from the combined keywords array
        $all_keywords = array_values(array_unique(array_filter($all_keywords, function($kw) {
            return mb_strlen(trim($kw)) > 1;
        })));
        
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
