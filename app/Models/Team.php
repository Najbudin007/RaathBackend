<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['name', 'position', 'description', 'status', 'email', 'image', 'facebook', 'linkedin', 'website', 'type', 'phone', 'achievements'];

    protected $casts = [
        'achievements' => 'array',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
