<?php

namespace App\Models;
use App\Traits\HasSlug;
use Illuminate\Support\Str;
use App\Models\PortfolioCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['title', 'category_id', 'description', 'status', 'case_study', 'feature_image'];

    
    public function category()
    {
        return $this->belongsTo(PortfolioCategory::class);
    }
   
}