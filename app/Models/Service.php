<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title','category_id', 'sub_title', 'status', 'icon', 'description'];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class,'category_id');
    }
}