<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\Admin\TagRequest;
use Illuminate\Support\Str;

class TagController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = Tag::latest()->get();

        return view('admin.pages.tags.index',compact('tags'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.tags.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Tag\TagRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        Tag::create($request->validated());
        
        $notification = Str::toastMsg(config('custom.msg.create'),'success');

        return redirect()->route('admin.tags.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TagRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.pages.tags.edit',compact('tag'));
    }
    
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        $notification = Str::toastMsg(config('custom.msg.update'),'success');
        return redirect()->route('admin.tags.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Tag $tag)
    {
        try {
            // Delete the record
            Tag $tag->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Record deleted successfully!'
                ]);
            }

            // Return redirect for regular requests
            $notification = Str::toastMsg(config('custom.msg.delete'),'success');
            return redirect()->back()->with($notification);
            
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete record: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }

}