<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TempleRequest;
use App\Models\Temple;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TempleController extends Controller
{
    /**
     * Display a listing of the temples.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $temples = Temple::latest()->get();
        return view('admin.pages.temple.index', compact('temples'));
    }

    /**
     * Show the form for creating a new temple.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.temple.create', compact('statusOptions'));
    }

    /**
     * Store a newly created temple in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(TempleRequest $request)
    {
        $data = $request->validated();
        Temple::create($data);
        $notification = Str::toastMsg(config('custom.msg.create'), 'success');
        return redirect()->route('admin.temples.index')->with($notification);
    }

    /**
     * Display the specified temple.
     *
     * @param \App\Models\Temple $temple
     * @return \Illuminate\Http\Response
     */
    public function show(Temple $temple)
    {
        return view('admin.pages.temple.show', compact('temple'));
    }

    /**
     * Show the form for editing the specified temple.
     *
     * @param \App\Models\Temple $temple
     * @return \Illuminate\Http\Response
     */
    public function edit(Temple $temple)
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.temples.edit', compact('temple', 'statusOptions'));
    }


    /**
     * Update the specified temple in storage.
     *
     * @param \App\Http\Requests\Admin\TempleRequest $request
     * @param \App\Models\Temple $temple
     * @return \Illuminate\Http\Response
     */

    public function update(TempleRequest $request, Temple $temple)
    {
        $data = $request->validated();
        $temple->update($data);
        $notification = Str::toastMsg(config('custom.msg.update'), 'success');
        return redirect()->route('admin.temples.index')->with($notification);
    }


    /**
     * Remove the specified temple from storage.
     *
     * @param \App\Models\Temple $temple
     * @return \Illuminate\Http\Response
     */

    public function destroy(Temple $temple)
    {
        $temple->delete();
        $notification = Str::toastMsg(config('custom.msg.delete'), 'success');
        return redirect()->route('admin.temples.index')->with($notification);
    }

}
