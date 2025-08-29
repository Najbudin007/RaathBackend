<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    /**
     * Record a transaction
     */
    public static function recordTransaction($data)
    {
        return Transaction::create([
            'user_id' => $data['user_id'] ?? null,
            'transaction_id' => Transaction::generateTransactionId(),
            'type' => $data['type'],
            'reference_type' => $data['reference_type'] ?? null,
            'reference_id' => $data['reference_id'] ?? null,
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'USD',
            'status' => $data['status'] ?? 'pending',
            'payment_method' => $data['payment_method'],
            'payment_gateway' => $data['payment_gateway'] ?? null,
            'description' => $data['description'] ?? null,
            'metadata' => $data['metadata'] ?? [],
        ]);
    }

    /**
     * Record order transaction
     */
    public static function recordOrderTransaction($order)
    {
        return self::recordTransaction([
            'user_id' => $order->user_id,
            'type' => 'order',
            'reference_type' => 'App\Models\Order',
            'reference_id' => $order->id,
            'amount' => $order->total,
            'currency' => 'USD',
            'status' => 'completed',
            'payment_method' => $order->payment_method,
            'payment_gateway' => 'stripe', // Default gateway
            'description' => "Order #{$order->order_number}",
            'metadata' => [
                'order_number' => $order->order_number,
                'subtotal' => $order->subtotal,
                'tax' => $order->tax,
                'shipping' => $order->shipping,
            ],
        ]);
    }

    /**
     * Record membership transaction
     */
    public static function recordMembershipTransaction($membership)
    {
        return self::recordTransaction([
            'user_id' => $membership->user_id,
            'type' => 'membership',
            'reference_type' => 'App\Models\UserMembership',
            'reference_id' => $membership->id,
            'amount' => $membership->amount_paid,
            'currency' => 'USD',
            'status' => 'completed',
            'payment_method' => $membership->payment_method,
            'payment_gateway' => 'stripe', // Default gateway
            'description' => "Membership: {$membership->membershipPlan->name}",
            'metadata' => [
                'plan_name' => $membership->membershipPlan->name,
                'duration_days' => $membership->membershipPlan->duration_days,
                'start_date' => $membership->start_date,
                'end_date' => $membership->end_date,
            ],
        ]);
    }

    /**
     * Record donation transaction
     */
    public static function recordDonationTransaction($donation)
    {
        return self::recordTransaction([
            'user_id' => $donation->user_id,
            'type' => 'donation',
            'reference_type' => 'App\Models\Donation',
            'reference_id' => $donation->id,
            'amount' => $donation->amount,
            'currency' => 'USD',
            'status' => 'completed',
            'payment_method' => $donation->payment_method,
            'payment_gateway' => 'stripe', // Default gateway
            'description' => $donation->message ?: "Donation to project",
            'metadata' => [
                'donor_name' => $donation->donor_name,
                'donor_email' => $donation->donor_email,
                'project_id' => $donation->project_id,
                'is_anonymous' => $donation->is_anonymous,
            ],
        ]);
    }
}
