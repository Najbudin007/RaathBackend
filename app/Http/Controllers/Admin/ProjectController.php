<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::withCount(['donations', 'sponsorshipTiers', 'budgetBreakdowns']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by featured
        if ($request->has('is_featured') && $request->is_featured != '') {
            $query->where('is_featured', $request->is_featured);
        }

        $projects = $query->orderBy('created_at', 'desc')
                         ->paginate(15);

        return view('admin.pages.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('projects/gallery', 'public');
            }
            $data['images'] = $imagePaths;
        }

        // Handle design documents upload
        if ($request->hasFile('design_docs')) {
            $docPaths = [];
            foreach ($request->file('design_docs') as $doc) {
                $docPaths[] = $doc->store('projects/documents', 'public');
            }
            $data['design_docs'] = $docPaths;
        }

        // Handle boolean fields
        $data['is_featured'] = $request->has('is_featured');

        // Set default collected_amount
        $data['collected_amount'] = $data['collected_amount'] ?? 0;

        $project = Project::create($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load([
            'donations', 
            'sponsorshipTiers', 
            'budgetBreakdowns',
            'documents'
        ]);
        
        // Get statistics
        $stats = [
            'total_donations' => $project->donations()->count(),
            'total_donated' => $project->donations()->sum('amount'),
            'total_sponsors' => $project->sponsorshipTiers()->count(),
            'budget_items' => $project->budgetBreakdowns()->count(),
            'progress_percentage' => $project->progress_percentage,
            'days_remaining' => $project->days_remaining,
        ];

        return view('admin.pages.projects.show', compact('project', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.pages.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            // Delete old images
            if ($project->images) {
                foreach ($project->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('projects/gallery', 'public');
            }
            $data['images'] = $imagePaths;
        }

        // Handle design documents upload
        if ($request->hasFile('design_docs')) {
            // Delete old documents
            if ($project->design_docs) {
                foreach ($project->design_docs as $oldDoc) {
                    Storage::disk('public')->delete($oldDoc);
                }
            }
            
            $docPaths = [];
            foreach ($request->file('design_docs') as $doc) {
                $docPaths[] = $doc->store('projects/documents', 'public');
            }
            $data['design_docs'] = $docPaths;
        }

        // Handle boolean fields
        $data['is_featured'] = $request->has('is_featured');

        $project->update($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            
            // Check if project has donations
            if ($project->donations()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete project with existing donations.'
                ], 403);
            }

            // Delete images
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            
            if ($project->images) {
                foreach ($project->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            // Delete documents
            if ($project->design_docs) {
                foreach ($project->design_docs as $doc) {
                    Storage::disk('public')->delete($doc);
                }
            }

            // Delete related records
            $project->sponsorshipTiers()->delete();
            $project->budgetBreakdowns()->delete();
            $project->documents()->delete();

            $project->delete();

            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found or could not be deleted.'
            ], 404);
        }
    }

    /**
     * Toggle project featured status
     */
    public function toggleFeatured(Project $project)
    {
        try {
            $project->update([
                'is_featured' => !$project->is_featured
            ]);

            $status = $project->is_featured ? 'featured' : 'unfeatured';

            return response()->json([
                'success' => true,
                'message' => "Project {$status} successfully!"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project featured status.'
            ], 500);
        }
    }

    /**
     * Update project status
     */
    public function updateStatus(Request $request, Project $project)
    {
        $request->validate([
            'status' => 'required|in:planning,active,on-hold,completed,cancelled'
        ]);

        try {
            $project->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => "Project status updated to {$request->status} successfully!"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project status.'
            ], 500);
        }
    }

    /**
     * Remove single image from gallery
     */
    public function removeImage(Request $request, Project $project)
    {
        $request->validate([
            'image_path' => 'required|string'
        ]);

        try {
            if ($project->images && in_array($request->image_path, $project->images)) {
                // Delete file from storage
                Storage::disk('public')->delete($request->image_path);
                
                // Remove from array
                $images = array_values(array_filter($project->images, function($image) use ($request) {
                    return $image !== $request->image_path;
                }));
                
                $project->update(['images' => $images]);

                return response()->json([
                    'success' => true,
                    'message' => 'Image removed successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Image not found.'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove image.'
            ], 500);
        }
    }

    /**
     * Remove single document
     */
    public function removeDocument(Request $request, Project $project)
    {
        $request->validate([
            'doc_path' => 'required|string'
        ]);

        try {
            if ($project->design_docs && in_array($request->doc_path, $project->design_docs)) {
                // Delete file from storage
                Storage::disk('public')->delete($request->doc_path);
                
                // Remove from array
                $docs = array_values(array_filter($project->design_docs, function($doc) use ($request) {
                    return $doc !== $request->doc_path;
                }));
                
                $project->update(['design_docs' => $docs]);

                return response()->json([
                    'success' => true,
                    'message' => 'Document removed successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Document not found.'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove document.'
            ], 500);
        }
    }
}

