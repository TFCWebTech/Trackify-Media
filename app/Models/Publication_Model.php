<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication_Model extends Model
{
    use HasFactory;
    protected $table = 'mediaoutlet';
    protected $primaryKey = 'gidMediaOutlet_id';

    // Specify any fields that are not mass assignable
    // protected $guarded = [];
    protected $fillable = [
        'gidMediaOutlet',
        'MediaOutlet',
        'gidMediaType',
        'gidPublicationType',
        'gidTier', 
        'Language', 
        'Masthead', 
        'Priority', 
        'ShortName', 
        'Status', 
        'CreatedOn', 
        'CreatedBy',
        'MediaOutletCorrections'
    ];
    public $timestamps = false; 
    protected $casts = [
        'gidTier' => 'nullable', // Ensure gidTier can be nullable
    ];
}
