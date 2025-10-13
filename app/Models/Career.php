<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['title', 'description','job_type', 'position_id', 'status', 'expired_date', 'image'];

    public function role()
    {
        return $this->belongsTo(JobRole::class, 'position_id');
    }
}
