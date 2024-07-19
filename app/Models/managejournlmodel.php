<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managejournlmodel extends Model
{
    use HasFactory;
    protected $table = 'journalist';
    protected $primaryKey = 'journalist_id';

    // Specify any fields that are not mass assignable
    protected $guarded = [];

    protected $fillable = [
        'gidJournalist',
        'Journalist',
        'JEmailId',
        'Status', // Add this line
        'CreatedOn', // Include token here
    ];
    public $timestamps = false; // Disable the updated_at column
}
