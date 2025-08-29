<?php

namespace App\Http\Controllers;

use App\Models\BudgetBreakdown;
use App\Http\Resources\BudgetBreakdownResource;
use App\Http\Requests\BudgetBreakdown\StoreBudgetBreakdownRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BudgetBreakdownController extends Controller
{
    /**
     * Display a listing of budget breakdowns for a project.
     */
    public function index(Request $request): JsonResponse
    {
        $query = BudgetBreakdown::query();

        // Filter by project
        if ($request->has('project_id')) {
            $query->byProject($request->project_id);
        }

        $breakdowns = $query->active()->ordered()->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Budget breakdowns retrieved successfully',
            'data' => BudgetBreakdownResource::collection($breakdowns),
            'pagination' => [
                'current_page' => $breakdowns->currentPage(),
                'last_page' => $breakdowns->lastPage(),
                'per_page' => $breakdowns->perPage(),
                'total' => $breakdowns->total(),
            ],
        ]);
    }

    /**
     * Store a newly created budget breakdown.
     */
    public function store(StoreBudgetBreakdownRequest $request): JsonResponse
    {
        $breakdown = BudgetBreakdown::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Budget breakdown created successfully',
            'data' => new BudgetBreakdownResource($breakdown),
        ], 201);
    }

    /**
     * Display the specified budget breakdown.
     */
    public function show(BudgetBreakdown $budgetBreakdown): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Budget breakdown retrieved successfully',
            'data' => new BudgetBreakdownResource($budgetBreakdown),
        ]);
    }

    /**
     * Update the specified budget breakdown.
     */
    public function update(StoreBudgetBreakdownRequest $request, BudgetBreakdown $budgetBreakdown): JsonResponse
    {
        $budgetBreakdown->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Budget breakdown updated successfully',
            'data' => new BudgetBreakdownResource($budgetBreakdown),
        ]);
    }

    /**
     * Remove the specified budget breakdown.
     */
    public function destroy(BudgetBreakdown $budgetBreakdown): JsonResponse
    {
        $budgetBreakdown->delete();

        return response()->json([
            'success' => true,
            'message' => 'Budget breakdown deleted successfully',
        ]);
    }
}
