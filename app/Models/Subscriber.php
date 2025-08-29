<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'city',
        'membership_status',
        'whatsapp_opt_in',
        'email_opt_in',
        'status',
        'email_verified_at',
        'verification_token',
        'preferences',
    ];

    protected $casts = [
        'whatsapp_opt_in' => 'boolean',
        'email_opt_in' => 'boolean',
        'email_verified_at' => 'datetime',
        'preferences' => 'array',
    ];

    protected $hidden = [
        'verification_token',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeUnsubscribed($query)
    {
        return $query->where('status', 'unsubscribed');
    }

    public function scopeEmailOptIn($query)
    {
        return $query->where('email_opt_in', true);
    }

    public function scopeWhatsappOptIn($query)
    {
        return $query->where('whatsapp_opt_in', true);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeByMembershipStatus($query, $status)
    {
        return $query->where('membership_status', $status);
    }

    // Methods
    public function generateVerificationToken()
    {
        $this->verification_token = Str::random(64);
        $this->save();
        return $this->verification_token;
    }

    public function verifyEmail()
    {
        $this->email_verified_at = now();
        $this->verification_token = null;
        $this->save();
    }

    public function unsubscribe()
    {
        $this->status = 'unsubscribed';
        $this->email_opt_in = false;
        $this->whatsapp_opt_in = false;
        $this->save();
    }

    public function resubscribe()
    {
        $this->status = 'active';
        $this->email_opt_in = true;
        $this->save();
    }

    public function isVerified()
    {
        return !is_null($this->email_verified_at);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isUnsubscribed()
    {
        return $this->status === 'unsubscribed';
    }
}
