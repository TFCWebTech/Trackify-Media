<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client_competetor_industry extends Model
{
    use HasFactory;
    
    protected $table = 'client_competetor_industry';
    protected $primaryKey = 'client_competetor_industry_id';
    public $timestamps = false; // Disable Laravel's default timestamps
    protected $fillable = [
        'news_details_id',
        'company_id',
        'competitor_id',
        'Industry_id',
    ];
}
