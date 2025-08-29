<?php

namespace App\Http\Controllers;

use App\Http\Resources\MembershipPlanResource;
use App\Models\MembershipPlan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of active membership plans.
     */
    public function index(): JsonResponse
    {
        $plans = MembershipPlan::active()->ordered()->get();

        return response()->json([
            'success' => true,
            'message' => 'Membership plans retrieved successfully',
            'data' => MembershipPlanResource::collection($plans),
        ]);
    }

    /**
     * Get membership benefits comparison.
     */
    public function benefitsComparison(): JsonResponse
    {
        $plans = MembershipPlan::active()->ordered()->get();

        $benefits = [
            'seating_priority' => 'Seating Priority',
            'annual_kit_type' => 'Annual Kit',
            'newsletter_frequency' => 'Newsletter',
            'events_access' => 'Events Access',
            'certificate_type' => 'Certificate',
        ];

        $comparison = [];
        foreach ($benefits as $key => $label) {
            $comparison[$key] = [
                'label' => $label,
                'values' => $plans->pluck($key, 'tier_name')->toArray(),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Membership benefits comparison retrieved successfully',
            'data' => [
                'plans' => MembershipPlanResource::collection($plans),
                'benefits_comparison' => $comparison,
            ],
        ]);
    }

    /**
     * Display the specified membership plan.
     */
    public function show(MembershipPlan $membershipPlan): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Membership plan retrieved successfully',
            'data' => new MembershipPlanResource($membershipPlan),
        ]);
    }
}
