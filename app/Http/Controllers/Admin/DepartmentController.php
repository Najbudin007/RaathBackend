<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::all();
        return view('admin.pages.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.department.create', compact('statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
      
        $data = $request->validated();
        // if($request->hasFile('icon')) {
        //     $data['icon'] = $request->file('icon')->store(Filepath::DEPARTMENT, 'public');
        // }
        Department::create($data);
        return redirect()->route('admin.departments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.department.edit', compact('department', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $data = $request->validated();
        // if ($request->hasFile('icon')) {
        //     if ($department->icon) {
        //         Storage::delete($department->icon);
        //     }
        //     $data['icon'] = $request->file('icon')->store(Filepath::DEPARTMENT, 'public');
        // }
        $department->update($data);
        return redirect()->route('admin.departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        // if ($department->icon) {
        //     Storage::delete($department->icon);
        // }
        $department->delete();
        return redirect()->route('admin.departments.index');
    }
}
