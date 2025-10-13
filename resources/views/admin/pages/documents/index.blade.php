@extends('admin.layouts.main')
@section('title', 'Documents')
@section('content')
    <div class="box-content">
        <div class="d-flex justify-content-between mb-3">
            <h3>Documents</h3>
            <a href="{{ route('admin.documents.create') }}" class="btn btn-primary"><i class="ri-add-line"></i> Upload Document</a>
        </div>
        <form action="{{ route('admin.documents.index') }}" method="GET" class="row g-3 mb-3">
            <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="project_id" class="form-select">
                    <option value="">All Projects</option>
                    @foreach($projects as $proj)
                        <option value="{{ $proj->id }}" {{ request('project_id') == $proj->id ? 'selected' : '' }}>{{ $proj->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image</option>
                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-1"><button class="btn btn-primary w-100">Filter</button></div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr><th>Title</th><th>Project</th><th>Type</th><th>Size</th><th>Downloads</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($documents as $key => $doc)
                    <tr id="row_{{ $key }}">
                        <td><strong>{{ $doc->title }}</strong><br><small>{{ $doc->file_name }}</small></td>
                        <td>{{ $doc->project->title ?? 'General' }}</td>
                        <td><span class="badge bg-info">{{ strtoupper($doc->type) }}</span></td>
                        <td>{{ number_format($doc->file_size / 1024, 2) }} KB</td>
                        <td>{{ $doc->download_count ?? 0 }}</td>
                        <td><span class="badge bg-{{ $doc->is_active ? 'success' : 'secondary' }}">{{ $doc->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.documents.show', $doc->id) }}" class="btn btn-sm btn-info"><i class="ri-eye-line"></i></a>
                                <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-sm btn-primary"><i class="ri-edit-line"></i></a>
                                <button onclick="confirmDelete('{{ route('admin.documents.destroy', $doc->id) }}', {{ $key }}, '{{ csrf_token() }}')" class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No documents found</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $documents->links() }}
    </div>
@endsection
@section('scripts')<script src="{{ asset('assets/js/ajax-delete.js') }}"></script>@endsection

