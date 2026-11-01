<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSentNews extends Model
{
    use HasFactory;

    protected $table = 'client_sent_news';

    protected $fillable = [
        'news_details_id',
        'client_id',
        'sent_date',
    ];
}
