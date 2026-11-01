<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competitor_Model extends Model
{
    use HasFactory;
    protected $table = 'competitor';
    protected $primaryKey = 'competitor_id';
    public $timestamps = false; // Disable Laravel's default timestamps

    protected $fillable = [
        'Competitor_name',
        'client_id',
        'is_active',
        'Keywords',
    ];
    public function client()
    {
        return $this->belongsTo(Client_Model::class, 'client_id', 'client_id');
    }
}
