<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Gallery::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        // Filter by featured
        if ($request->has('is_featured') && $request->is_featured != '') {
            $query->where('is_featured', $request->is_featured);
        }

        $galleries = $query->orderBy('sort_order', 'asc')
                          ->orderBy('created_at', 'desc')
                          ->paginate(24); // Show 24 items per page for gallery grid

        // Get unique categories for filter
        $categories = Gallery::distinct()->pluck('category')->filter()->sort()->values();

        return view('admin.pages.gallery.index', compact('galleries', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Gallery::distinct()->pluck('category')->filter()->sort()->values();
        return view('admin.pages.gallery.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imagePath = $image->store('gallery/images', 'public');
            $data['image_url'] = $imagePath;

            // Generate thumbnail if it's an image type
            if ($data['type'] == 'image') {
                try {
                    $thumbnailPath = 'gallery/thumbnails/' . basename($imagePath);
                    $img = Image::make($image);
                    $img->fit(300, 300);
                    Storage::disk('public')->put($thumbnailPath, (string) $img->encode());
                    $data['thumbnail_url'] = $thumbnailPath;
                } catch (\Exception $e) {
                    // If thumbnail generation fails, use original image
                    $data['thumbnail_url'] = $imagePath;
                }
            }
        }

        // Handle metadata
        if ($request->has('metadata')) {
            $data['metadata'] = $request->metadata;
        }

        // Handle boolean fields
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        // Set sort order if not provided
        if (empty($data['sort_order'])) {
            $data['sort_order'] = Gallery::max('sort_order') + 1;
        }

        $gallery = Gallery::create($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.pages.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $categories = Gallery::distinct()->pluck('category')->filter()->sort()->values();
        return view('admin.pages.gallery.edit', compact('gallery', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image_url')) {
            // Delete old images
            if ($gallery->image_url && !str_starts_with($gallery->image_url, 'http')) {
                Storage::disk('public')->delete($gallery->image_url);
            }
            if ($gallery->thumbnail_url && !str_starts_with($gallery->thumbnail_url, 'http')) {
                Storage::disk('public')->delete($gallery->thumbnail_url);
            }

            $image = $request->file('image_url');
            $imagePath = $image->store('gallery/images', 'public');
            $data['image_url'] = $imagePath;

            // Generate thumbnail if it's an image type
            if ($data['type'] == 'image') {
                try {
                    $thumbnailPath = 'gallery/thumbnails/' . basename($imagePath);
                    $img = Image::make($image);
                    $img->fit(300, 300);
                    Storage::disk('public')->put($thumbnailPath, (string) $img->encode());
                    $data['thumbnail_url'] = $thumbnailPath;
                } catch (\Exception $e) {
                    // If thumbnail generation fails, use original image
                    $data['thumbnail_url'] = $imagePath;
                }
            }
        }

        // Handle metadata
        if ($request->has('metadata')) {
            $data['metadata'] = $request->metadata;
        }

        // Handle boolean fields
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $gallery->update($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            
            // Delete images
            if ($gallery->image_url && !str_starts_with($gallery->image_url, 'http')) {
                Storage::disk('public')->delete($gallery->image_url);
            }
            if ($gallery->thumbnail_url && !str_starts_with($gallery->thumbnail_url, 'http')) {
                Storage::disk('public')->delete($gallery->thumbnail_url);
            }

            $gallery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gallery item deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery item not found or could not be deleted.'
            ], 404);
        }
    }

    /**
     * Toggle gallery item active status
     */
    public function toggleStatus(Gallery $gallery)
    {
        try {
            $gallery->update([
                'is_active' => !$gallery->is_active
            ]);

            $status = $gallery->is_active ? 'activated' : 'deactivated';

            return response()->json([
                'success' => true,
                'message' => "Gallery item {$status} successfully!"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update gallery item status.'
            ], 500);
        }
    }

    /**
     * Toggle gallery item featured status
     */
    public function toggleFeatured(Gallery $gallery)
    {
        try {
            $gallery->update([
                'is_featured' => !$gallery->is_featured
            ]);

            $status = $gallery->is_featured ? 'featured' : 'unfeatured';

            return response()->json([
                'success' => true,
                'message' => "Gallery item {$status} successfully!"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update gallery item featured status.'
            ], 500);
        }
    }

    /**
     * Bulk upload images
     */
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'required|string|max:255',
            'type' => 'required|in:image,video'
        ]);

        $uploaded = 0;
        $category = $request->category;
        $type = $request->type;
        $sortOrder = Gallery::max('sort_order') + 1;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $imagePath = $image->store('gallery/images', 'public');
                    
                    // Generate thumbnail
                    $thumbnailPath = null;
                    if ($type == 'image') {
                        try {
                            $thumbnailPath = 'gallery/thumbnails/' . basename($imagePath);
                            $img = Image::make($image);
                            $img->fit(300, 300);
                            Storage::disk('public')->put($thumbnailPath, (string) $img->encode());
                        } catch (\Exception $e) {
                            $thumbnailPath = $imagePath;
                        }
                    }

                    Gallery::create([
                        'title' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME),
                        'image_url' => $imagePath,
                        'thumbnail_url' => $thumbnailPath,
                        'category' => $category,
                        'type' => $type,
                        'is_active' => true,
                        'is_featured' => false,
                        'sort_order' => $sortOrder++,
                    ]);

                    $uploaded++;
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', "{$uploaded} images uploaded successfully!");
    }
}

