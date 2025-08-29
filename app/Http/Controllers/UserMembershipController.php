<?php

namespace App\Http\Controllers;

use App\Http\Requests\Membership\JoinMembershipRequest;
use App\Http\Requests\Membership\RenewMembershipRequest;
use App\Http\Resources\UserMembershipResource;
use App\Models\MembershipPlan;
use App\Models\UserMembership;
use App\Services\NotificationService;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserMembershipController extends Controller
{
    /**
     * Display a listing of user's memberships.
     */
    public function index(Request $request): JsonResponse
    {
        $memberships = $request->user()
            ->userMemberships()
            ->with('membershipPlan')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'User memberships retrieved successfully',
            'data' => UserMembershipResource::collection($memberships),
        ]);
    }

    /**
     * Join a membership plan.
     */
    public function join(JoinMembershipRequest $request): JsonResponse
    {
        $plan = MembershipPlan::findOrFail($request->membership_plan_id);
        $user = $request->user();

        // Check if user already has an active membership
        $activeMembership = $user->userMemberships()
            ->where('status', 'active')
            ->first();

        if ($activeMembership) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active membership',
            ], 400);
        }

        $membership = UserMembership::create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addDays($plan->duration_days),
            'status' => 'active',
            'amount_paid' => $plan->price,
            'payment_method' => 'online', // Default payment method
            'transaction_id' => 'TXN_' . time(),
        ]);

        // Record transaction
        TransactionService::recordMembershipTransaction($membership);

        // Send notification
        NotificationService::sendMembershipNotification($membership);

        return response()->json([
            'success' => true,
            'message' => 'Membership joined successfully',
            'data' => new UserMembershipResource($membership->load('membershipPlan')),
        ], 201);
    }

    /**
     * Cancel user membership.
     */
    public function cancel(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Find active membership for user
        $activeMembership = $user->userMemberships()
            ->where('status', 'active')
            ->first();

        if (!$activeMembership) {
            return response()->json([
                'success' => false,
                'message' => 'No active membership found',
            ], 404);
        }

        $activeMembership->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Membership cancelled successfully',
        ]);
    }

    /**
     * Renew user membership.
     */
    public function renew(RenewMembershipRequest $request): JsonResponse
    {
        $user = $request->user();
        $plan = MembershipPlan::findOrFail($request->membership_plan_id);
        
        // Find the latest active/expired membership of this user & plan
        $latestMembership = $user->userMemberships()
            ->where('membership_plan_id', $plan->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$latestMembership) {
            return response()->json([
                'success' => false,
                'message' => 'No previous membership found for this plan',
            ], 404);
        }

        // If active → extend end_date = old_end_date + duration_days
        // If expired → start new cycle (start_date = now())
        if ($latestMembership->status === 'active' && $latestMembership->end_date > now()) {
            $latestMembership->update([
                'end_date' => Carbon::parse($latestMembership->end_date)->addDays($plan->duration_days),
            ]);
        } else {
            // Create new membership cycle
            $latestMembership = UserMembership::create([
                'user_id' => $user->id,
                'membership_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration_days),
                'status' => 'active',
                'amount_paid' => $plan->price,
                'payment_method' => 'online',
                'transaction_id' => 'TXN_' . time(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Membership renewed successfully',
            'data' => new UserMembershipResource($latestMembership->load('membershipPlan')),
        ]);
    }

    /**
     * Get user membership history.
     */
    public function history(Request $request): JsonResponse
    {
        $memberships = $request->user()
            ->userMemberships()
            ->with('membershipPlan')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Membership history retrieved successfully',
            'data' => UserMembershipResource::collection($memberships),
        ]);
    }
}
