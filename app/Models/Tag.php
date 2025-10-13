<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['title'];

    public function posts()
    {
        return $this->belongsToMany(tag::class);
    }
    
}
