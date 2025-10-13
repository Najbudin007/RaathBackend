<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasSlug;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'blog_category_id',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'featured_image',
    ];


    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
