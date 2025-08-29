<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tier_name',
        'color_theme',
        'description',
        'price',
        'duration_days',
        'benefits',
        'detailed_benefits',
        'seating_priority',
        'annual_kit_type',
        'newsletter_frequency',
        'events_access',
        'certificate_type',
        'is_volunteer_based',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'benefits' => 'array',
        'detailed_benefits' => 'array',
        'is_active' => 'boolean',
        'is_volunteer_based' => 'boolean',
    ];

    // Relationships
    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeVolunteerBased($query)
    {
        return $query->where('is_volunteer_based', true);
    }

    public function scopePaidBased($query)
    {
        return $query->where('is_volunteer_based', false);
    }
}
