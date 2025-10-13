<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Metrics;
use App\Http\Requests\Admin\MetricsRequest;
use Illuminate\Support\Str;

class MetricsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $metrics = Metrics::latest()->get();

        return view('admin.pages.metrics.index',compact('metrics'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.metrics.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Metrics\MetricsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MetricsRequest $request)
    {
        Metrics::create($request->validated());
        
        $notification = Str::toastMsg(config('custom.msg.create'),'success');

        return redirect()->route('admin.metrics.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Metrics  $metrics
     * @return \Illuminate\Http\Response
     */
    public function show(Metrics $metrics)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MetricsRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Metrics  $metrics
     * @return \Illuminate\Http\Response
     */
    public function edit(Metrics $metric)
    {
        return view('admin.pages.metrics.edit',compact('metric'));
    }
    
    public function update(MetricsRequest $request, Metrics $metrics)
    {
        $metrics->update($request->validated());
        $notification = Str::toastMsg(config('custom.msg.update'),'success');
        return redirect()->route('admin.metrics.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Metrics  $metrics
     * @return \Illuminate\Http\Response
     */
    public function destroy(Metrics $metrics)
    {
        $metrics->delete();
        $notification = Str::toastMsg(config('custom.msg.delete'),'success');
        return response($notification);
    }

}