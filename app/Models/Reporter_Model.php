<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporter_Model extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'user_id';

    // Specify any fields that are not mass assignable
    protected $guarded = [];

    protected $fillable = [
        'user_name',
        'user_email',
        'user_status',
        'user_type', // Add this line
        'token', // Include token here
    ];
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; // Disable the updated_at column
}
