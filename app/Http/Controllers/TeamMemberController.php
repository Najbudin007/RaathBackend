<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of active team members.
     */
    public function index(): JsonResponse
    {
        $teamMembers = TeamMember::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Team members retrieved successfully',
            'data' => $teamMembers,
        ]);
    }
}
