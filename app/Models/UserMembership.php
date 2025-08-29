<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'status',
        'application_status',
        'photo_url',
        'application_notes',
        'membership_id_number',
        'amount_paid',
        'payment_method',
        'transaction_id',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'rejected_at',
        'rejected_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount_paid' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('application_status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('application_status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('application_status', 'rejected');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Methods
    public function generateMembershipId()
    {
        $prefix = 'RF';
        $year = date('Y');
        $sequence = str_pad($this->id, 4, '0', STR_PAD_LEFT);
        return "{$prefix}{$year}{$sequence}";
    }

    public function approve($approvedByUserId)
    {
        $this->update([
            'application_status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approvedByUserId,
            'membership_id_number' => $this->generateMembershipId(),
        ]);
    }

    public function reject($rejectedByUserId, $reason = null)
    {
        $this->update([
            'application_status' => 'rejected',
            'rejected_at' => now(),
            'rejected_by' => $rejectedByUserId,
            'rejection_reason' => $reason,
        ]);
    }

    public function isPending()
    {
        return $this->application_status === 'pending';
    }

    public function isApproved()
    {
        return $this->application_status === 'approved';
    }

    public function isRejected()
    {
        return $this->application_status === 'rejected';
    }
}
