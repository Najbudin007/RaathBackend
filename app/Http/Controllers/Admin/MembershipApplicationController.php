<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserMembershipResource;
use App\Models\UserMembership;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MembershipApplicationController extends Controller
{
    /**
     * Display a listing of membership applications.
     */
    public function index(Request $request): JsonResponse
    {
        $query = UserMembership::with(['user', 'membershipPlan', 'approvedBy', 'rejectedBy']);

        // Filter by application status
        if ($request->has('status')) {
            $query->where('application_status', $request->status);
        } else {
            $query->where('application_status', 'pending');
        }

        // Filter by membership plan
        if ($request->has('membership_plan_id')) {
            $query->where('membership_plan_id', $request->membership_plan_id);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Membership applications retrieved successfully',
            'data' => UserMembershipResource::collection($applications),
            'pagination' => [
                'current_page' => $applications->currentPage(),
                'last_page' => $applications->lastPage(),
                'per_page' => $applications->perPage(),
                'total' => $applications->total(),
            ],
        ]);
    }

    /**
     * Display the specified membership application.
     */
    public function show(UserMembership $application): JsonResponse
    {
        $application->load(['user', 'membershipPlan', 'approvedBy', 'rejectedBy']);

        return response()->json([
            'success' => true,
            'message' => 'Membership application retrieved successfully',
            'data' => new UserMembershipResource($application),
        ]);
    }

    /**
     * Approve a membership application.
     */
    public function approve(Request $request, UserMembership $application): JsonResponse
    {
        if ($application->application_status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Application is not pending',
            ], 400);
        }

        $application->approve($request->user()->id);

        // Send notification to user
        NotificationService::sendNotification(
            $application->user_id,
            'membership_approved',
            'Membership Application Approved',
            'Your membership application has been approved! Welcome to Rathyatra Foundation.',
            ['membership_id' => $application->id, 'membership_plan' => $application->membershipPlan->name]
        );

        return response()->json([
            'success' => true,
            'message' => 'Membership application approved successfully',
            'data' => new UserMembershipResource($application->load(['user', 'membershipPlan'])),
        ]);
    }

    /**
     * Reject a membership application.
     */
    public function reject(Request $request, UserMembership $application): JsonResponse
    {
        if ($application->application_status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Application is not pending',
            ], 400);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $application->reject($request->user()->id, $request->rejection_reason);

        // Send notification to user
        NotificationService::sendNotification(
            $application->user_id,
            'membership_rejected',
            'Membership Application Update',
            'Your membership application has been reviewed. Please check the details.',
            ['membership_id' => $application->id, 'rejection_reason' => $request->rejection_reason]
        );

        return response()->json([
            'success' => true,
            'message' => 'Membership application rejected successfully',
            'data' => new UserMembershipResource($application->load(['user', 'membershipPlan'])),
        ]);
    }

    /**
     * Get membership application statistics.
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_applications' => UserMembership::where('application_status', '!=', null)->count(),
            'pending_applications' => UserMembership::pending()->count(),
            'approved_applications' => UserMembership::approved()->count(),
            'rejected_applications' => UserMembership::rejected()->count(),
            'recent_applications' => UserMembership::where('application_status', '!=', null)
                ->where('created_at', '>=', now()->subDays(7))
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Membership application statistics retrieved successfully',
            'data' => $stats,
        ]);
    }
}
