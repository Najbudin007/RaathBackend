<?php

namespace App\Http\Controllers\Admin;

use App\Filepath;
use App\Models\Team;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\TeamRequest;

class TeamController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = Team::latest()->get();

        return view('admin.pages.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.teams.create', compact('statusOptions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Team\TeamRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        $data = $request->validated();
       
        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store(Filepath::TEAM, 'public');
        }
        Team::create($data);

        $notification = Str::toastMsg(config('custom.msg.create'), 'success');

        return redirect()->route('admin.teams.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TeamRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.teams.edit', compact('team', 'statusOptions'));
    }

    public function update(TeamRequest $request, Team $team)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($team->image) {
                Storage::delete($team->image);
            }
            $data['image'] = $request->file('image')->store(Filepath::TEAM, 'public');
        }
        $team->update($data);
        $notification = Str::toastMsg(config('custom.msg.update'), 'success');
        return redirect()->route('admin.teams.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        try {
            // Delete the image file if it exists
            if ($team->image) {
                Storage::delete($team->image);
            }
            
            // Delete the team record
            $team->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Team deleted successfully!'
                ]);
            }

            // Return redirect for regular requests
            $notification = Str::toastMsg(config('custom.msg.delete'), 'success');
            return redirect()->route('admin.teams.index')->with($notification);
            
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete team: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to delete team: ' . $e->getMessage());
        }
    }
}
