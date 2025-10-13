<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug',
        'icon',
        'color',
        'requirements',
        'time',
        'unit',
        'status'
    ];

    protected $casts = [
        'requirements' => 'array',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }
}
