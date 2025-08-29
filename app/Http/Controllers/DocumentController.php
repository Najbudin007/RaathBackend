<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Resources\DocumentResource;
use App\Http\Requests\Document\StoreDocumentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of documents.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Document::query();

        // Filter by project
        if ($request->has('project_id')) {
            $query->byProject($request->project_id);
        }

        // Filter by type
        if ($request->has('type')) {
            $query->byType($request->type);
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Only show public documents for non-admin users
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            $query->public();
        }

        $documents = $query->active()->ordered()->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Documents retrieved successfully',
            'data' => DocumentResource::collection($documents),
            'pagination' => [
                'current_page' => $documents->currentPage(),
                'last_page' => $documents->lastPage(),
                'per_page' => $documents->perPage(),
                'total' => $documents->total(),
            ],
        ]);
    }

    /**
     * Store a newly created document.
     */
    public function store(StoreDocumentRequest $request): JsonResponse
    {
        $document = Document::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Document created successfully',
            'data' => new DocumentResource($document),
        ], 201);
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document): JsonResponse
    {
        // Check if user can access this document
        if (!$document->is_public && (!auth()->user() || !auth()->user()->isAdmin())) {
            return response()->json([
                'success' => false,
                'message' => 'Document not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Document retrieved successfully',
            'data' => new DocumentResource($document),
        ]);
    }

    /**
     * Update the specified document.
     */
    public function update(StoreDocumentRequest $request, Document $document): JsonResponse
    {
        $document->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Document updated successfully',
            'data' => new DocumentResource($document),
        ]);
    }

    /**
     * Remove the specified document.
     */
    public function destroy(Document $document): JsonResponse
    {
        // Delete the file from storage if it exists
        if ($document->file_url && Storage::disk('public')->exists($document->file_url)) {
            Storage::disk('public')->delete($document->file_url);
        }

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document deleted successfully',
        ]);
    }

    /**
     * Download a document.
     */
    public function download(Document $document): JsonResponse
    {
        // Check if user can access this document
        if (!$document->is_public && (!auth()->user() || !auth()->user()->isAdmin())) {
            return response()->json([
                'success' => false,
                'message' => 'Document not found',
            ], 404);
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_url)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found',
            ], 404);
        }

        // Increment download count
        $document->incrementDownloadCount();

        // Return download URL
        return response()->json([
            'success' => true,
            'message' => 'Download URL generated successfully',
            'data' => [
                'download_url' => $document->full_file_url,
                'file_name' => $document->file_name,
                'file_size' => $document->file_size,
            ],
        ]);
    }
}
