<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Send a notification to a user
     */
    public static function sendNotification($userId, $type, $title, $message, $data = [], $channel = 'in_app')
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'channel' => $channel,
            'sent_at' => now(),
        ]);
    }

    /**
     * Send order notification
     */
    public static function sendOrderNotification($order)
    {
        $title = 'Order Confirmed';
        $message = "Your order #{$order->order_number} has been placed successfully. Total: \${$order->total}";
        $data = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'total' => $order->total,
        ];

        return self::sendNotification(
            $order->user_id,
            'order',
            $title,
            $message,
            $data,
            'in_app'
        );
    }

    /**
     * Send membership notification
     */
    public static function sendMembershipNotification($membership)
    {
        $plan = $membership->membershipPlan;
        $title = 'Membership Activated';
        $message = "Your {$plan->name} membership has been activated. Valid until " . $membership->end_date->format('M d, Y');
        $data = [
            'membership_id' => $membership->id,
            'plan_name' => $plan->name,
            'end_date' => $membership->end_date,
        ];

        return self::sendNotification(
            $membership->user_id,
            'membership',
            $title,
            $message,
            $data,
            'in_app'
        );
    }

    /**
     * Send donation notification
     */
    public static function sendDonationNotification($donation)
    {
        $title = 'Donation Received';
        $message = "Thank you for your donation of \${$donation->amount}. Your generosity makes a difference!";
        $data = [
            'donation_id' => $donation->id,
            'amount' => $donation->amount,
            'project_id' => $donation->project_id,
        ];

        return self::sendNotification(
            $donation->user_id,
            'donation',
            $title,
            $message,
            $data,
            'in_app'
        );
    }

    /**
     * Send system notification to all users
     */
    public static function sendSystemNotificationToAll($title, $message, $data = [])
    {
        $users = User::where('is_active', true)->get();
        
        foreach ($users as $user) {
            self::sendNotification(
                $user->id,
                'system',
                $title,
                $message,
                $data,
                'in_app'
            );
        }
    }
}
