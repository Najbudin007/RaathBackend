<?php

namespace App\Http\Controllers;

use App\Http\Requests\Membership\JoinMembershipRequest;
use App\Http\Requests\Membership\RenewMembershipRequest;
use App\Http\Requests\Membership\ApplyMembershipRequest;
use App\Http\Resources\UserMembershipResource;
use App\Models\MembershipPlan;
use App\Models\UserMembership;
use App\Services\NotificationService;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Apply for membership with photo upload.
     */
    public function apply(ApplyMembershipRequest $request): JsonResponse
    {
        $plan = MembershipPlan::findOrFail($request->membership_plan_id);
        $user = $request->user();

        // Check if user already has a pending application
        $pendingApplication = $user->userMemberships()
            ->where('application_status', 'pending')
            ->first();

        if ($pendingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending membership application',
            ], 400);
        }

        // Handle photo upload
        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = 'membership_photos/' . time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public', $photoName);
            $photoUrl = $photoName;
        }

        $membership = UserMembership::create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'start_date' => now(), // Set current date for application
            'end_date' => now()->addDays($plan->duration_days), // Set end date based on plan
            'status' => 'pending',
            'application_status' => 'pending',
            'photo_url' => $photoUrl,
            'application_notes' => $request->application_notes,
            'amount_paid' => $plan->is_volunteer_based ? 0 : $plan->price,
            'payment_method' => $plan->is_volunteer_based ? 'volunteer' : 'online',
            'transaction_id' => $plan->is_volunteer_based ? null : 'TXN_' . time(),
        ]);

        // Send notification to admin about new application
        NotificationService::sendSystemNotificationToAll(
            'New Membership Application',
            "New membership application received from {$user->name} for {$plan->name} tier.",
            ['type' => 'membership_application', 'user_id' => $user->id, 'membership_id' => $membership->id]
        );

        return response()->json([
            'success' => true,
            'message' => 'Membership application submitted successfully',
            'data' => new UserMembershipResource($membership->load('membershipPlan')),
        ], 201);
    }

    /**
     * Get user's membership application status.
     */
    public function applicationStatus(Request $request): JsonResponse
    {
        $application = $request->user()
            ->userMemberships()
            ->with(['membershipPlan', 'approvedBy', 'rejectedBy'])
            ->where('application_status', '!=', null)
            ->latest()
            ->first();

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'No membership application found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Application status retrieved successfully',
            'data' => new UserMembershipResource($application),
        ]);
    }
}
