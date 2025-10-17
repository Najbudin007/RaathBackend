<?php

namespace App\Http\Controllers\Admin;

use App\Filepath;
use App\Models\Career;
use App\Models\JobRole;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\CareerRequest;

class CareerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $careers = Career::with('role')->get();

        return view('admin.pages.careers.index', compact('careers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        $roleOptions = JobRole::pluck('title','id');
        return view('admin.pages.careers.create', compact('statusOptions', 'roleOptions', 'statusOptions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Career\CareerRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CareerRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store(Filepath::CAREER);
        }
        Career::create($data);

        $notification = Str::toastMsg(config('custom.msg.create'), 'success');

        return redirect()->route('admin.careers.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function show(Career $career) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CareerRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function edit(Career $career)
    {
        $statusOptions = StatusEnum::lists();
        $roleOptions = JobRole::pluck('title','id');
        return view('admin.pages.careers.edit', compact('career', 'statusOptions', 'roleOptions'));
    }

    public function update(CareerRequest $request, Career $career)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($career->image) {
                Storage::delete($career->image);
            }
            $data['image'] = $request->file('image')->store(Filepath::CAREER);
        }
        $career->update($data);
        $notification = Str::toastMsg(config('custom.msg.update'), 'success');
        return redirect()->route('admin.careers.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function destroy(Career $career)
    {
        try {
            // Delete the image if it exists
            if ($career->image) {
                Storage::delete($career->image);
            }
            
            // Delete the career record
            $career->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Career deleted successfully!'
                ]);
            }

            // Return redirect for regular requests
            $notification = Str::toastMsg(config('custom.msg.delete'), 'success');
            return redirect()->route('admin.careers.index')->with($notification);
            
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete career: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to delete career: ' . $e->getMessage());
        }
    }
}
