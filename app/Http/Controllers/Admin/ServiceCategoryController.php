<?php

namespace App\Http\Controllers\Admin;

use App\Filepath;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ServiceCategoryRequest;

class ServiceCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $servicecategories = ServiceCategory::latest()->get();

        return view('admin.pages.service_categories.index',compact('servicecategories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.service_categories.create',compact('statusOptions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ServiceCategory\ServiceCategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceCategoryRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store(Filepath::SERVICE_CATEGORY);
        }
        ServiceCategory::create($data);

        $notification = Str::toastMsg(config('custom.msg.create'),'success');

        return redirect()->route('admin.service_categories.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceCategory $serviceCategory)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ServiceCategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.service_categories.edit',compact('serviceCategory','statusOptions'));
    }
    
    public function update(ServiceCategoryRequest $request, ServiceCategory $serviceCategory)
    {
        $data = $request->validated();
        if ($request->hasFile('icon')) {
            if ($serviceCategory->icon) {
                Storage::delete($serviceCategory->icon);
            }
            $data['icon'] = $request->file('icon')->store(Filepath::SERVICE_CATEGORY);
        }
        $serviceCategory->update($data);
        $notification = Str::toastMsg(config('custom.msg.update'),'success');
        return redirect()->route('admin.service_categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        try {
            // Delete the icon if it exists
            if ($serviceCategory->icon) {
                Storage::delete($serviceCategory->icon);
            }
            
            // Delete the service category record
            $serviceCategory->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service category deleted successfully!'
                ]);
            }

            // Return redirect for regular requests
            $notification = Str::toastMsg(config('custom.msg.delete'),'success');
            return redirect()->route('admin.service_categories.index')->with($notification);
            
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete service category: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to delete service category: ' . $e->getMessage());
        }
    }

}