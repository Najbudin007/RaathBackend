<?php

namespace App\Http\Controllers;

use App\Http\Requests\Yatra\StoreYatraRequest;
use App\Http\Resources\YatraResource;
use App\Models\Yatra;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class YatraController extends Controller
{
    /**
     * Display a listing of yatras.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Yatra::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by city
        if ($request->has('city')) {
            $query->byCity($request->city);
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->featured();
        }

        $yatras = $query->orderBy('sort_order')
            ->orderBy('start_date')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Yatras retrieved successfully',
            'data' => YatraResource::collection($yatras),
            'pagination' => [
                'current_page' => $yatras->currentPage(),
                'last_page' => $yatras->lastPage(),
                'per_page' => $yatras->perPage(),
                'total' => $yatras->total(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created yatra.
     */
    public function store(StoreYatraRequest $request): JsonResponse
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $yatra = Yatra::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Yatra created successfully',
            'data' => new YatraResource($yatra),
        ], 201);
    }

    /**
     * Display the specified yatra.
     */
    public function show(Yatra $yatra): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Yatra retrieved successfully',
            'data' => new YatraResource($yatra),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Yatra $yatra)
    {
        //
    }

    /**
     * Update the specified yatra.
     */
    public function update(StoreYatraRequest $request, Yatra $yatra): JsonResponse
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $yatra->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Yatra updated successfully',
            'data' => new YatraResource($yatra),
        ]);
    }

    /**
     * Remove the specified yatra.
     */
    public function destroy(Request $request, Yatra $yatra): JsonResponse
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $yatra->delete();

        return response()->json([
            'success' => true,
            'message' => 'Yatra deleted successfully',
        ]);
    }

    /**
     * Get the next upcoming yatra.
     */
    public function nextYatra(): JsonResponse
    {
        $nextYatra = Yatra::getNextYatra();

        if (!$nextYatra) {
            return response()->json([
                'success' => false,
                'message' => 'No upcoming yatras found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Next yatra retrieved successfully',
            'data' => new YatraResource($nextYatra),
        ]);
    }

    /**
     * Get upcoming yatras for homepage.
     */
    public function upcomingYatras(): JsonResponse
    {
        $upcomingYatras = Yatra::upcoming()
            ->orderBy('start_date')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Upcoming yatras retrieved successfully',
            'data' => YatraResource::collection($upcomingYatras),
        ]);
    }
}
