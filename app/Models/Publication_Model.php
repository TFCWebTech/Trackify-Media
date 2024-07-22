<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication_Model extends Model
{
    use HasFactory;
    protected $table = 'mediaoutlet';
    protected $primaryKey = 'gidMediaOutlet_id';
    protected $guarded = [];
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
        'UpdatedOn',
        'UpdatedBy',
        'MediaOutletCorrections'
    ];
    public $timestamps = false; // Disable Laravel's default timestamps

   
}
