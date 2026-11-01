<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry_model extends Model
{
    use HasFactory;
    protected $table = 'industry';
    protected $primaryKey = 'Industry_id';
    protected $guarded = [];
    protected $fillable = [
        'Industry_name',
        'client_id',
        'competitor_id',
        'is_active',
        'Keywords',
       
    ];
    public $timestamps = false; // Disable Laravel's default timestamps
    public function client()
    {
        return $this->belongsTo(Client_Model::class, 'client_id', 'client_id');
    }
}
