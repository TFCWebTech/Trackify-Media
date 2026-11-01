<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deleteNews extends Model
{
    use HasFactory;
    
    protected $table = 'delete_news';

    protected $fillable = [
        'news_details_id',
        'client_id',
        'is_delete',
        'is_hide',
        'headline',
        'summary',
        'is_update',
    ];

    public $timestamps = false;
}
