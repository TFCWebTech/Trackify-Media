<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddRate_Model extends Model
{
    use HasFactory;
    protected $table = 'addrate';
    protected $primaryKey = 'gidAddRate_id';

    // Specify any fields that are not mass assignable
    protected $guarded = [];

    protected $fillable = [
        'gidAddRate',
        'Rate',
        'Circulation_Fig',
        'gidMediaType', // Add this line
        'gidMediaOutlet', // Include token here
        'gidEdition',
        'gidSupplement',
        'Status',
        'CreatedOn',
        'NewRate',
        'CreatedBy',
        'UpdatedOn'
    ];
    public $timestamps = false; // Disable the updated_at column
}

  
