<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of active projects.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Project::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'active');
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured) {
            $query->where('is_featured', true);
        }

        // Filter by planning status for Rath Making page
        if ($request->has('planning') && $request->planning) {
            $query->where('status', 'planning');
        }

        $projects = $query->with(['sponsorshipTiers', 'budgetBreakdowns', 'documents'])
                         ->orderBy('created_at', 'desc')
                         ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Projects retrieved successfully',
            'data' => ProjectResource::collection($projects),
            'pagination' => [
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
                'per_page' => $projects->perPage(),
                'total' => $projects->total(),
            ],
        ]);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): JsonResponse
    {
        // Load all related data for the project
        $project->load(['donations', 'sponsorshipTiers', 'budgetBreakdowns', 'documents']);

        return response()->json([
            'success' => true,
            'message' => 'Project retrieved successfully',
            'data' => new ProjectResource($project),
        ]);
    }

    /**
     * Get project details for Rath Making page
     */
    public function rathMaking(): JsonResponse
    {
        $project = Project::where('status', 'planning')
                         ->with(['sponsorshipTiers', 'budgetBreakdowns', 'documents'])
                         ->first();

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Rath Making project not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Rath Making project retrieved successfully',
            'data' => new ProjectResource($project),
        ]);
    }
}
