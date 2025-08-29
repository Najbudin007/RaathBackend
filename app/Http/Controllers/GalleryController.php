<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gallery\StoreGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery items.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Gallery::query();

        // Filter by category
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->featured();
        }

        // Only active items
        $query->active();

        $gallery = $query->ordered()->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Gallery items retrieved successfully',
            'data' => GalleryResource::collection($gallery),
            'pagination' => [
                'current_page' => $gallery->currentPage(),
                'last_page' => $gallery->lastPage(),
                'per_page' => $gallery->perPage(),
                'total' => $gallery->total(),
            ],
        ]);
    }

    /**
     * Store a newly created gallery item.
     */
    public function store(StoreGalleryRequest $request): JsonResponse
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $gallery = Gallery::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Gallery item created successfully',
            'data' => new GalleryResource($gallery),
        ], 201);
    }

    /**
     * Display the specified gallery item.
     */
    public function show(Gallery $gallery): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Gallery item retrieved successfully',
            'data' => new GalleryResource($gallery),
        ]);
    }

    /**
     * Update the specified gallery item.
     */
    public function update(StoreGalleryRequest $request, Gallery $gallery): JsonResponse
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $gallery->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Gallery item updated successfully',
            'data' => new GalleryResource($gallery),
        ]);
    }

    /**
     * Remove the specified gallery item.
     */
    public function destroy(Request $request, Gallery $gallery): JsonResponse
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery item deleted successfully',
        ]);
    }

    /**
     * Get featured gallery items for homepage.
     */
    public function featured(): JsonResponse
    {
        $featuredGallery = Gallery::featured()
            ->active()
            ->ordered()
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Featured gallery items retrieved successfully',
            'data' => GalleryResource::collection($featuredGallery),
        ]);
    }
}
