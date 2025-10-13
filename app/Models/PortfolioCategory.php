<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PortfolioCategory extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['title', 'status'];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->icon
        );
    }
}