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
        $plans = MembershipPlan::where('is_active', true)
            ->orderBy('price')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Membership plans retrieved successfully',
            'data' => MembershipPlanResource::collection($plans),
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
