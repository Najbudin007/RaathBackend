<?php

namespace App\Http\Controllers\Admin;

use App\Filepath;
use App\Models\Blog;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Tag;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = Blog::with('category')->latest()->get();

        return view('admin.pages.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusOptions = StatusEnum::lists();
        $categories = BlogCategory::pluck('name','id');
        $tags = Tag::pluck('title','id')->toArray();
        return view('admin.pages.blogs.create', compact('statusOptions','categories','tags'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Blog\BlogRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store(Filepath::BLOG);
        }

        $blog = Blog::create($data);
        $blog->tags()->attach($request->tags);

        $notification = Str::toastMsg(config('custom.msg.create'), 'success');

        return redirect()->route('admin.blogs.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BlogRequest $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $statusOptions = StatusEnum::lists();
        $categories = BlogCategory::pluck('name','id');
        $tags = Tag::pluck('title','id')->toArray();
        return view('admin.pages.blogs.edit', compact('blog','statusOptions','categories','tags'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->update($request->validated());
        
        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::delete($blog->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store(Filepath::BLOG);
        }

        $blog->tags()->sync($request->tags);
        $notification = Str::toastMsg(config('custom.msg.update'), 'success');
        return redirect()->route('admin.blogs.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        try {
            // Delete the featured image if it exists
            if ($blog->featured_image) {
                Storage::delete($blog->featured_image);
            }
            
            // Delete the blog record
            $blog->delete();

            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Blog deleted successfully!'
                ]);
            }

            // Return redirect for regular requests
            $notification = Str::toastMsg(config('custom.msg.delete'), 'success');
            return redirect()->route('admin.blogs.index')->with($notification);
            
        } catch (\Exception $e) {
            // Return JSON response for AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete blog: ' . $e->getMessage()
                ], 500);
            }

            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to delete blog: ' . $e->getMessage());
        }
    }
}
