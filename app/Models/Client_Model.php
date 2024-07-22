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

    protected $fillable = [
        'client_name',
        'client_keywords',
        'cilent_status',
        'create_at',
        'sector_id',
        'client_type',
    ];
}
