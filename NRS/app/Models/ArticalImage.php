<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticalImage extends Model
{
    protected $table = 'artical_images';

    protected $fillable = [
        'artical_images_name',
    ];
    public $timestamps = false; // Disable timestamps
}
