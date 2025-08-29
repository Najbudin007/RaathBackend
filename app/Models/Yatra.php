<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yatra extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'city',
        'month',
        'collaborating_center',
        'start_date',
        'end_date',
        'status',
        'image',
        'details',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'details' => 'array',
        'is_featured' => 'boolean',
    ];

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    // Methods
    public static function getNextYatra()
    {
        return static::where('status', 'upcoming')
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->first();
    }

    public function getDaysUntilStart()
    {
        if (!$this->start_date) {
            return null;
        }
        
        return now()->diffInDays($this->start_date, false);
    }

    public function isUpcoming()
    {
        return $this->status === 'upcoming' && $this->start_date && $this->start_date > now();
    }
}
