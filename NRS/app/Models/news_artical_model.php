<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news_artical_model extends Model
{
    use HasFactory;
    protected $table = 'news_artical';
    protected $primaryKey = 'news_artical_id';
    public $timestamps = false; // Disable timestamps
    protected $fillable = [
        'news_details_id',
        'artical_images_id',
        'news_artical',
        'page_no',
        'create_at',
        'image_height',
        'image_width'
    ];

    public function articleImages()
    {
        return $this->belongsTo(ArticalImage::class, 'artical_images_id', 'artical_images_id');
    }
}
