<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'type',
        'file_url',
        'file_name',
        'file_size',
        'mime_type',
        'category',
        'is_public',
        'is_active',
        'download_count',
        'sort_order',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Methods
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    public function getFullFileUrlAttribute()
    {
        return asset('storage/' . $this->file_url);
    }
}
