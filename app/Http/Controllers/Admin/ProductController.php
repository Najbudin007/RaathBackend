<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        // Filter by featured
        if ($request->has('is_featured') && $request->is_featured != '') {
            $query->where('is_featured', $request->is_featured);
        }

        $products = $query->orderBy('sort_order', 'asc')
                         ->orderBy('name', 'asc')
                         ->paginate(15);

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.pages.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = Category::where('is_active', true)->orderBy('name')->get();
            
            // Debug: Log categories data
            \Log::info('Categories loaded for product create:', [
                'count' => $categories->count(),
                'categories' => $categories->toArray()
            ]);

            // If this is an AJAX request, return JSON for debugging
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'categories' => $categories,
                    'debug' => [
                        'categories_count' => $categories->count(),
                        'request_type' => request()->method(),
                        'request_headers' => request()->headers->all()
                    ]
                ]);
            }

            return view('admin.pages.products.create', compact('categories'));
            
        } catch (\Exception $e) {
            \Log::error('Error in product create method:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load create form: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->route('admin.products.index')
                ->with('error', 'Failed to load product creation form');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            // Debug: Log all request data
            \Log::info('Product Store Request Data:', [
                'all_data' => $request->all(),
                'files' => $request->allFiles(),
                'validated_data' => $request->validated(),
                'has_files' => [
                    'image' => $request->hasFile('image'),
                    'images' => $request->hasFile('images'),
                    'image_count' => $request->hasFile('images') ? count($request->file('images')) : 0
                ]
            ]);

            $data = $request->validated();

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            } else {
                $data['slug'] = Str::slug($data['slug']);
            }

            // Handle main image upload
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
                \Log::info('Main image uploaded:', ['path' => $data['image']]);
            }

            // Handle multiple images upload
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('products/gallery', 'public');
                }
                $data['images'] = $imagePaths;
                \Log::info('Gallery images uploaded:', ['paths' => $imagePaths]);
            }

            // Set sort order if not provided
            if (empty($data['sort_order'])) {
                $data['sort_order'] = Product::max('sort_order') + 1;
            }

            // Handle boolean fields
            $data['is_active'] = $request->has('is_active');
            $data['is_featured'] = $request->has('is_featured');

            // Debug: Log final data before creation
            \Log::info('Final data before Product::create:', $data);

            $product = Product::create($data);

            \Log::info('Product created successfully:', ['product_id' => $product->id]);

            // Return JSON response for debugging
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product created successfully!',
                    'product_id' => $product->id,
                    'debug_data' => [
                        'validated_data' => $request->validated(),
                        'final_data' => $data,
                        'files_received' => $request->allFiles()
                    ]
                ]);
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                    'input_data' => $request->all()
                ], 422);
            }

            throw $e;

        } catch (\Exception $e) {
            \Log::error('Product creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product creation failed: ' . $e->getMessage(),
                    'debug_data' => [
                        'error' => $e->getMessage(),
                        'input_data' => $request->all()
                    ]
                ], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'cartItems', 'orderItems']);
        
        // Get statistics
        $stats = [
            'total_orders' => $product->orderItems()->count(),
            'total_sold' => $product->orderItems()->sum('quantity'),
            'total_revenue' => $product->orderItems()->sum('total_price'),
            'in_carts' => $product->cartItems()->count(),
        ];

        return view('admin.pages.products.show', compact('product', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.pages.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            // Delete old images
            if ($product->images) {
                foreach ($product->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products/gallery', 'public');
            }
            $data['images'] = $imagePaths;
        }

        // Handle boolean fields
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Check if product has orders
            if ($product->orderItems()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete product with existing orders. Please contact support.'
                ], 403);
            }

            // Delete images
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            if ($product->images) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found or could not be deleted.'
            ], 404);
        }
    }

    /**
     * Toggle product active status
     */
    public function toggleStatus(Product $product)
    {
        try {
            $product->update([
                'is_active' => !$product->is_active
            ]);

            $status = $product->is_active ? 'activated' : 'deactivated';

            return response()->json([
                'success' => true,
                'message' => "Product {$status} successfully!"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status.'
            ], 500);
        }
    }

    /**
     * Toggle product featured status
     */
    public function toggleFeatured(Product $product)
    {
        try {
            $product->update([
                'is_featured' => !$product->is_featured
            ]);

            $status = $product->is_featured ? 'featured' : 'unfeatured';

            return response()->json([
                'success' => true,
                'message' => "Product {$status} successfully!"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product featured status.'
            ], 500);
        }
    }

    /**
     * Remove single image from gallery
     */
    public function removeImage(Request $request, Product $product)
    {
        $request->validate([
            'image_path' => 'required|string'
        ]);

        try {
            if ($product->images && in_array($request->image_path, $product->images)) {
                // Delete file from storage
                Storage::disk('public')->delete($request->image_path);
                
                // Remove from array
                $images = array_values(array_filter($product->images, function($image) use ($request) {
                    return $image !== $request->image_path;
                }));
                
                $product->update(['images' => $images]);

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

}

