<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobRole;
use App\Http\Requests\Admin\JobRoleRequest;
use Illuminate\Support\Str;

class JobRoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jobroles = JobRole::get();

        return view('admin.pages.job_roles.index',compact('jobroles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.job_roles.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\JobRole\JobRoleRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JobRoleRequest $request)
    {
        JobRole::create($request->validated());
        
        $notification = Str::toastMsg(config('custom.msg.create'),'success');

        return redirect()->route('admin.job_roles.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobRole  $jobRole
     * @return \Illuminate\Http\Response
     */
    public function show(JobRole $jobRole)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\JobRoleRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobRole  $jobRole
     * @return \Illuminate\Http\Response
     */
    public function edit(JobRole $jobRole)
    {
        return view('admin.pages.job_roles.edit',compact('jobRole'));
    }
    
    public function update(JobRoleRequest $request, JobRole $jobRole)
    {
        $jobRole->update($request->validated());
        $notification = Str::toastMsg(config('custom.msg.update'),'success');
        return redirect()->route('admin.job_roles.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobRole  $jobRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobRole $jobRole)
    {
        $jobRole->delete();
        $notification = Str::toastMsg(config('custom.msg.delete'),'success');
        return response($notification);
    }

}