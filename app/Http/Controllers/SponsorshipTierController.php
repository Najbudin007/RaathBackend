<?php

namespace App\Http\Controllers;

use App\Models\SponsorshipTier;
use App\Http\Resources\SponsorshipTierResource;
use App\Http\Requests\SponsorshipTier\StoreSponsorshipTierRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SponsorshipTierController extends Controller
{
    /**
     * Display a listing of sponsorship tiers for a project.
     */
    public function index(Request $request): JsonResponse
    {
        $query = SponsorshipTier::query();

        // Filter by project
        if ($request->has('project_id')) {
            $query->byProject($request->project_id);
        }

        $tiers = $query->active()->ordered()->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Sponsorship tiers retrieved successfully',
            'data' => SponsorshipTierResource::collection($tiers),
            'pagination' => [
                'current_page' => $tiers->currentPage(),
                'last_page' => $tiers->lastPage(),
                'per_page' => $tiers->perPage(),
                'total' => $tiers->total(),
            ],
        ]);
    }

    /**
     * Store a newly created sponsorship tier.
     */
    public function store(StoreSponsorshipTierRequest $request): JsonResponse
    {
        $tier = SponsorshipTier::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Sponsorship tier created successfully',
            'data' => new SponsorshipTierResource($tier),
        ], 201);
    }

    /**
     * Display the specified sponsorship tier.
     */
    public function show(SponsorshipTier $sponsorshipTier): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Sponsorship tier retrieved successfully',
            'data' => new SponsorshipTierResource($sponsorshipTier),
        ]);
    }

    /**
     * Update the specified sponsorship tier.
     */
    public function update(StoreSponsorshipTierRequest $request, SponsorshipTier $sponsorshipTier): JsonResponse
    {
        $sponsorshipTier->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Sponsorship tier updated successfully',
            'data' => new SponsorshipTierResource($sponsorshipTier),
        ]);
    }

    /**
     * Remove the specified sponsorship tier.
     */
    public function destroy(SponsorshipTier $sponsorshipTier): JsonResponse
    {
        $sponsorshipTier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sponsorship tier deleted successfully',
        ]);
    }
}
