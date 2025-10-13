<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('slug', 'like', "%{$request->search}%")
                  ->orWhere('content', 'like', "%{$request->search}%");
            });
        }

        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        $pages = $query->orderBy('title')->paginate(15);

        return view('admin.pages.cms.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.cms.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatePage($request);
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }
        
        $data['is_active'] = $request->has('is_active');

        Page::create($data);

        return redirect()->route('admin.cms-pages.index')->with('success', 'Page created successfully!');
    }

    public function show(Page $cmsPage)
    {
        return view('admin.pages.cms.show', compact('cmsPage'));
    }

    public function edit(Page $cmsPage)
    {
        return view('admin.pages.cms.edit', compact('cmsPage'));
    }

    public function update(Request $request, Page $cmsPage)
    {
        $data = $this->validatePage($request, $cmsPage->id);
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }
        
        $data['is_active'] = $request->has('is_active');

        $cmsPage->update($data);

        return redirect()->route('admin.cms-pages.index')->with('success', 'Page updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $page = Page::findOrFail($id);
            $page->delete();

            return response()->json([
                'success' => true,
                'message' => 'Page deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete page.'
            ], 404);
        }
    }

    public function toggleStatus(Page $cmsPage)
    {
        try {
            $cmsPage->update(['is_active' => !$cmsPage->is_active]);
            $status = $cmsPage->is_active ? 'activated' : 'deactivated';

            return response()->json([
                'success' => true,
                'message' => "Page {$status} successfully!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }

    protected function validatePage($request, $ignoreId = null)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug' . ($ignoreId ? ',' . $ignoreId : ''),
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ];

        return $request->validate($rules);
    }
}

