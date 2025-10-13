<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembershipPlanController extends Controller
{
    public function index(Request $request)
    {
        $query = MembershipPlan::withCount('userMemberships');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('tier_name', 'like', "%{$request->search}%");
            });
        }

        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        $plans = $query->orderBy('sort_order')->orderBy('price')->paginate(15);

        return view('admin.pages.memberships.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.pages.memberships.create');
    }

    public function store(Request $request)
    {
        $data = $this->validate($request);
        $data['is_active'] = $request->has('is_active');
        $data['is_volunteer_based'] = $request->has('is_volunteer_based');
        
        if (empty($data['sort_order'])) {
            $data['sort_order'] = MembershipPlan::max('sort_order') + 1;
        }

        MembershipPlan::create($data);

        return redirect()->route('admin.memberships.index')->with('success', 'Membership plan created successfully!');
    }

    public function show(MembershipPlan $membership)
    {
        $membership->loadCount('userMemberships');
        $stats = [
            'total_members' => $membership->userMemberships()->count(),
            'active_members' => $membership->userMemberships()->where('status', 'active')->count(),
            'revenue' => $membership->userMemberships()->where('status', 'active')->count() * $membership->price,
        ];

        return view('admin.pages.memberships.show', compact('membership', 'stats'));
    }

    public function edit(MembershipPlan $membership)
    {
        return view('admin.pages.memberships.edit', compact('membership'));
    }

    public function update(Request $request, MembershipPlan $membership)
    {
        $data = $this->validate($request);
        $data['is_active'] = $request->has('is_active');
        $data['is_volunteer_based'] = $request->has('is_volunteer_based');

        $membership->update($data);

        return redirect()->route('admin.memberships.index')->with('success', 'Membership plan updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $membership = MembershipPlan::findOrFail($id);
            
            if ($membership->userMemberships()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete membership plan with active subscriptions.'
                ], 403);
            }

            $membership->delete();

            return response()->json([
                'success' => true,
                'message' => 'Membership plan deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete membership plan.'
            ], 404);
        }
    }

    public function toggleStatus(MembershipPlan $membership)
    {
        try {
            $membership->update(['is_active' => !$membership->is_active]);
            $status = $membership->is_active ? 'activated' : 'deactivated';

            return response()->json([
                'success' => true,
                'message' => "Membership plan {$status} successfully!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }

    protected function validate($request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'tier_name' => 'required|string|max:255',
            'color_theme' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'benefits' => 'nullable|array',
            'detailed_benefits' => 'nullable|array',
            'seating_priority' => 'nullable|string|max:255',
            'annual_kit_type' => 'nullable|string|max:255',
            'newsletter_frequency' => 'nullable|string|max:255',
            'events_access' => 'nullable|string|max:255',
            'certificate_type' => 'nullable|string|max:255',
            'is_volunteer_based' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }
}

