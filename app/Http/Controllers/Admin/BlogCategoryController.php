<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Http\Requests\Admin\BlogCategoryRequest;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogcategories = BlogCategory::get();

        return view('admin.pages.blog_categories.index', compact('blogcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        return view('admin.pages.blog_categories.create', compact('statusOptions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BlogCategory\BlogCategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryRequest $request)
    {
        BlogCategory::create($request->validated());

        $notification = Str::toastMsg(config('custom.msg.create'), 'success');

        return redirect()->route('admin.blog_categories.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BlogCategory $blogCategory) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BlogCategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogCategory $blogCategory)
    {
        $statusOptions = StatusEnum::lists();

        return view('admin.pages.blog_categories.edit', compact('blogCategory', 'statusOptions'));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $blogCategory->update($request->validated());
        $notification = Str::toastMsg(config('custom.msg.update'), 'success');
        return redirect()->route('admin.blog_categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(BlogCategory $blogCategory)
    {
        try {
            // Delete the record
            BlogCategory $blogCategory->delete();

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
