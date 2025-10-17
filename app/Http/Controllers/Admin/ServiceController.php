<?php

namespace App\Http\Controllers\Admin;

use App\Filepath;
use App\Models\Service;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::with(['category:id,title'])->latest()->get();

        return view('admin.pages.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        $categories = ServiceCategory::pluck('id','title');
        return view('admin.pages.services.create', compact('statusOptions','categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Service\ServiceRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store(Filepath::SERVICES);
        }

        Service::create($data);

        $notification = Str::toastMsg(config('custom.msg.create'), 'success');

        return redirect()->route('admin.services.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ServiceRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $statusOptions = StatusEnum::lists();
        $categories = ServiceCategory::pluck('id','title');
        return view('admin.pages.services.edit', compact('service', 'statusOptions','categories'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->validated();
        if ($request->hasFile('icon')) {
            if ($service->icon) {
                Storage::delete($service->icon);
            }
            $data['icon'] = $request->file('icon')->store(Filepath::SERVICES);
        }
        $service->update($data);
        $notification = Str::toastMsg(config('custom.msg.update'), 'success');
        return redirect()->route('admin.services.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        try {
            // Delete the icon file if it exists
            if ($service->icon) {
                Storage::delete($service->icon);
            }
            
            // Delete the service record
            $service->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service deleted successfully!'
                ]);
            }

            // Return redirect for regular requests
            $notification = Str::toastMsg(config('custom.msg.delete'), 'success');
            return redirect()->route('admin.services.index')->with($notification);
            
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete service: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to delete service: ' . $e->getMessage());
        }
    }
}
