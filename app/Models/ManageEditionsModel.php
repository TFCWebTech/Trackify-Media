<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageEditionsModel extends Model
{
    use HasFactory;
     // Specify the table if it's not the plural form of the model name
     protected $table = 'edition';

     protected $primaryKey = 'edition_id';
 
     // Specify any fields that are not mass assignable
     protected $guarded = [];

    

}
