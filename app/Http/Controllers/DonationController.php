<?php

namespace App\Http\Controllers;

use App\Http\Requests\Donation\StoreDonationRequest;
use App\Http\Resources\DonationResource;
use App\Models\Donation;
use App\Models\Project;
use App\Services\NotificationService;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of donations (admin only).
     */
    public function index(Request $request): JsonResponse
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $donations = Donation::with(['user', 'project'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Donations retrieved successfully',
            'data' => DonationResource::collection($donations),
            'pagination' => [
                'current_page' => $donations->currentPage(),
                'last_page' => $donations->lastPage(),
                'per_page' => $donations->perPage(),
                'total' => $donations->total(),
            ],
        ]);
    }

    /**
     * Store a newly created donation.
     */
    public function store(StoreDonationRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // If user is authenticated, use their info
        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
            $data['donor_name'] = $request->user()->name;
            $data['donor_email'] = $request->user()->email;
        }

        $donation = Donation::create($data);

        // Update project collected amount if donation is for a project
        if ($donation->project_id) {
            $project = Project::find($donation->project_id);
            $project->increment('collected_amount', $donation->amount);
        }

        // Record transaction if user is authenticated
        if ($donation->user_id) {
            TransactionService::recordDonationTransaction($donation);
            NotificationService::sendDonationNotification($donation);
        }

        return response()->json([
            'success' => true,
            'message' => 'Donation created successfully',
            'data' => new DonationResource($donation->load('project')),
        ], 201);
    }

    /**
     * Display the specified donation.
     */
    public function show(Request $request, Donation $donation): JsonResponse
    {
        // Check if user can view this donation
        if ($donation->user_id && $donation->user_id !== $request->user()->id) {
            if (!$request->user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Donation retrieved successfully',
            'data' => new DonationResource($donation->load('project')),
        ]);
    }

    /**
     * Display user's donations.
     */
    public function myDonations(Request $request): JsonResponse
    {
        $donations = $request->user()
            ->donations()
            ->with('project')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'User donations retrieved successfully',
            'data' => DonationResource::collection($donations),
            'pagination' => [
                'current_page' => $donations->currentPage(),
                'last_page' => $donations->lastPage(),
                'per_page' => $donations->perPage(),
                'total' => $donations->total(),
            ],
        ]);
    }
}
