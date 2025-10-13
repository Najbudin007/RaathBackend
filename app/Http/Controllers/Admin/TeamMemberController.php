<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Http\Requests\Admin\UpdateTeamMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = TeamMember::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        $teamMembers = $query->orderBy('sort_order', 'asc')
                            ->orderBy('name', 'asc')
                            ->paginate(15);

        return view('admin.pages.team.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.pages.team.create');
    }

    public function store(StoreTeamMemberRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        if (empty($data['sort_order'])) {
            $data['sort_order'] = TeamMember::max('sort_order') + 1;
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member added successfully!');
    }

    public function show(TeamMember $team)
    {
        return view('admin.pages.team.show', compact('team'));
    }

    public function edit(TeamMember $team)
    {
        return view('admin.pages.team.edit', compact('team'));
    }

    public function update(UpdateTeamMemberRequest $request, TeamMember $team)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $team = TeamMember::findOrFail($id);
            
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }

            $team->delete();

            return response()->json([
                'success' => true,
                'message' => 'Team member deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Team member not found or could not be deleted.'
            ], 404);
        }
    }

    public function toggleStatus(TeamMember $team)
    {
        try {
            $team->update(['is_active' => !$team->is_active]);
            $status = $team->is_active ? 'activated' : 'deactivated';

            return response()->json([
                'success' => true,
                'message' => "Team member {$status} successfully!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }
}

