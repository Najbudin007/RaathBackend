<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('project');

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(15);
        $projects = Project::orderBy('title')->get();

        return view('admin.pages.documents.index', compact('documents', 'projects'));
    }

    public function create()
    {
        $projects = Project::orderBy('title')->get();
        return view('admin.pages.documents.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,image,video,other',
            'file_url' => 'required|file|max:10240',
            'category' => 'nullable|string|max:255',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('file_url')) {
            $file = $request->file('file_url');
            $data['file_url'] = $file->store('documents', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }

        $data['is_public'] = $request->has('is_public');
        $data['is_active'] = $request->has('is_active');

        Document::create($data);

        return redirect()->route('admin.documents.index')->with('success', 'Document uploaded successfully!');
    }

    public function show(Document $document)
    {
        $document->load('project');
        return view('admin.pages.documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $projects = Project::orderBy('title')->get();
        return view('admin.pages.documents.edit', compact('document', 'projects'));
    }

    public function update(Request $request, Document $document)
    {
        $data = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,image,video,other',
            'file_url' => 'nullable|file|max:10240',
            'category' => 'nullable|string|max:255',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('file_url')) {
            if ($document->file_url) {
                Storage::disk('public')->delete($document->file_url);
            }
            $file = $request->file('file_url');
            $data['file_url'] = $file->store('documents', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }

        $data['is_public'] = $request->has('is_public');
        $data['is_active'] = $request->has('is_active');

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Document updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $document = Document::findOrFail($id);
            if ($document->file_url) {
                Storage::disk('public')->delete($document->file_url);
            }
            $document->delete();
            return response()->json(['success' => true, 'message' => 'Document deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete.'], 404);
        }
    }
}

