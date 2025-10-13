<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temple extends Model
{
    protected $fillable = [
        'country',
        'count',
        'region',
        'lat',
        'lng',
    ];

    /**
     * Get the country of the temple.
     *
     * @return string
     */
    public function getCountryAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get the region of the temple.
     *
     * @return string|null
     */
    public function getRegionAttribute($value)
    {
        return $value ? ucfirst($value) : null;
    }
}
