<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency_Model extends Model
{
    use HasFactory;
    protected $table = 'agency';
    protected $primaryKey = 'gidAgency_id';
}
