<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipTier;
use App\Models\Project;
use Illuminate\Http\Request;

class SponsorshipTierController extends Controller
{
    public function index(Request $request)
    {
        $query = SponsorshipTier::with('project');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        $tiers = $query->orderBy('sort_order')->paginate(15);
        $projects = Project::orderBy('title')->get();

        return view('admin.pages.sponsorship-tiers.index', compact('tiers', 'projects'));
    }

    public function create()
    {
        $projects = Project::where('status', 'active')->orderBy('title')->get();
        return view('admin.pages.sponsorship-tiers.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'benefits' => 'nullable|array',
            'inscription_type' => 'nullable|string|max:255',
            'gifts' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->has('is_active');
        
        if (empty($data['sort_order'])) {
            $data['sort_order'] = SponsorshipTier::where('project_id', $data['project_id'])->max('sort_order') + 1;
        }

        SponsorshipTier::create($data);

        return redirect()->route('admin.sponsorship-tiers.index')->with('success', 'Sponsorship tier created successfully!');
    }

    public function show(SponsorshipTier $sponsorshipTier)
    {
        $sponsorshipTier->load('project');
        return view('admin.pages.sponsorship-tiers.show', compact('sponsorshipTier'));
    }

    public function edit(SponsorshipTier $sponsorshipTier)
    {
        $projects = Project::orderBy('title')->get();
        return view('admin.pages.sponsorship-tiers.edit', compact('sponsorshipTier', 'projects'));
    }

    public function update(Request $request, SponsorshipTier $sponsorshipTier)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'benefits' => 'nullable|array',
            'inscription_type' => 'nullable|string|max:255',
            'gifts' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->has('is_active');

        $sponsorshipTier->update($data);

        return redirect()->route('admin.sponsorship-tiers.index')->with('success', 'Sponsorship tier updated successfully!');
    }

    public function destroy($id)
    {
        try {
            SponsorshipTier::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Tier deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete tier.'], 404);
        }
    }

    public function toggleStatus(SponsorshipTier $sponsorshipTier)
    {
        try {
            $sponsorshipTier->update(['is_active' => !$sponsorshipTier->is_active]);
            return response()->json(['success' => true, 'message' => 'Status updated!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update.'], 500);
        }
    }
}

