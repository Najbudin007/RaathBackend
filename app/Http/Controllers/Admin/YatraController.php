<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Yatra;
use App\Http\Requests\Admin\StoreYatraRequest;
use App\Http\Requests\Admin\UpdateYatraRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class YatraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Yatra::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('collaborating_center', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by city
        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }

        // Filter by month
        if ($request->has('month') && $request->month != '') {
            $query->where('month', $request->month);
        }

        // Filter by featured
        if ($request->has('is_featured') && $request->is_featured != '') {
            $query->where('is_featured', $request->is_featured);
        }

        $yatras = $query->orderBy('start_date', 'desc')
                       ->orderBy('sort_order', 'asc')
                       ->paginate(15);

        // Get unique cities for filter
        $cities = Yatra::distinct()->pluck('city')->filter()->sort()->values();

        return view('admin.pages.yatras.index', compact('yatras', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.yatras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreYatraRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('yatras', 'public');
        }

        // Handle details JSON
        if ($request->has('details')) {
            $data['details'] = $request->details;
        }

        // Handle boolean fields
        $data['is_featured'] = $request->has('is_featured');

        // Set sort order if not provided
        if (empty($data['sort_order'])) {
            $data['sort_order'] = Yatra::max('sort_order') + 1;
        }

        $yatra = Yatra::create($data);

        return redirect()
            ->route('admin.yatras.index')
            ->with('success', 'Yatra created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Yatra $yatra)
    {
        // Get statistics
        $stats = [
            'days_until_start' => $yatra->getDaysUntilStart(),
            'is_upcoming' => $yatra->isUpcoming(),
            'duration_days' => $yatra->start_date && $yatra->end_date ? 
                $yatra->start_date->diffInDays($yatra->end_date) : 0,
        ];

        return view('admin.pages.yatras.show', compact('yatra', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Yatra $yatra)
    {
        return view('admin.pages.yatras.edit', compact('yatra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateYatraRequest $request, Yatra $yatra)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($yatra->image) {
                Storage::disk('public')->delete($yatra->image);
            }
            $data['image'] = $request->file('image')->store('yatras', 'public');
        }

        // Handle details JSON
        if ($request->has('details')) {
            $data['details'] = $request->details;
        }

        // Handle boolean fields
        $data['is_featured'] = $request->has('is_featured');

        $yatra->update($data);

        return redirect()
            ->route('admin.yatras.index')
            ->with('success', 'Yatra updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $yatra = Yatra::findOrFail($id);
            
            // Delete image
            if ($yatra->image) {
                Storage::disk('public')->delete($yatra->image);
            }

            $yatra->delete();

            return response()->json([
                'success' => true,
                'message' => 'Yatra deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Yatra not found or could not be deleted.'
            ], 404);
        }
    }

    /**
     * Toggle yatra featured status
     */
    public function toggleFeatured(Yatra $yatra)
    {
        try {
            $yatra->update([
                'is_featured' => !$yatra->is_featured
            ]);

            $status = $yatra->is_featured ? 'featured' : 'unfeatured';

            return response()->json([
                'success' => true,
                'message' => "Yatra {$status} successfully!"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update yatra featured status.'
            ], 500);
        }
    }

    /**
     * Update yatra status
     */
    public function updateStatus(Request $request, Yatra $yatra)
    {
        $request->validate([
            'status' => 'required|in:upcoming,ongoing,completed,cancelled'
        ]);

        try {
            $yatra->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => "Yatra status updated to {$request->status} successfully!"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update yatra status.'
            ], 500);
        }
    }
}

