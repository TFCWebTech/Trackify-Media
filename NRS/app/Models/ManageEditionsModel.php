<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageEditionsModel extends Model
{
    use HasFactory;
    protected $table = 'edition';
    protected $primaryKey = 'gidEdition_id';
    public $timestamps = false; // Disable Laravel's default timestamps

    protected $fillable = [
        'gidEdition',
        'Edition',
        'EditionOrder',
        'MediaOutletId',
        'Status',
        'CreatedOn',
        'CreatedBy',
        'UpdatedOn',
        'UpdatedBy',
        'ShortName'
    ];
}
