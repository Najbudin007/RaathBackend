<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'thumbnail_url',
        'category',
        'type',
        'alt_text',
        'is_active',
        'is_featured',
        'sort_order',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'metadata' => 'array',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    // Methods
    public function getFullImageUrlAttribute()
    {
        if (str_starts_with($this->image_url, 'http')) {
            return $this->image_url;
        }
        
        return asset('storage/' . $this->image_url);
    }

    public function getFullThumbnailUrlAttribute()
    {
        if (!$this->thumbnail_url) {
            return $this->full_image_url;
        }
        
        if (str_starts_with($this->thumbnail_url, 'http')) {
            return $this->thumbnail_url;
        }
        
        return asset('storage/' . $this->thumbnail_url);
    }
}
