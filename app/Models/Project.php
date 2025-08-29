<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'vision',
        'technical_specs',
        'design_docs',
        'image',
        'images',
        'target_amount',
        'collected_amount',
        'budget',
        'start_date',
        'end_date',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'budget' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'images' => 'array',
        'design_docs' => 'array',
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function sponsorshipTiers()
    {
        return $this->hasMany(SponsorshipTier::class);
    }

    public function budgetBreakdowns()
    {
        return $this->hasMany(BudgetBreakdown::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePlanning($query)
    {
        return $query->where('status', 'planning');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Accessors
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount > 0) {
            return round(($this->collected_amount / $this->target_amount) * 100, 2);
        }
        return 0;
    }

    public function getDaysRemainingAttribute()
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }
}
