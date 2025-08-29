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
        'image',
        'images',
        'target_amount',
        'collected_amount',
        'start_date',
        'end_date',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'images' => 'array',
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
