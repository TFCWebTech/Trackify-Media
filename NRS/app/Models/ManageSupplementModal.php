<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageSupplementModal extends Model
{
    use HasFactory;
    protected $table = 'supplements';
    protected $primaryKey = 'supplement_id';
    public $timestamps = false;
    protected $fillable = [
        'gidSupplement',
        'Supplement',
        'gidEdition',
        'Status',
        'CreatedOn',
        'CreatedBy'
    ];
   
}
