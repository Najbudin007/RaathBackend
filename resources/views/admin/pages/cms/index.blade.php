@extends('admin.layouts.main')
@section('title', 'Pages Management')

@section('content')
    <div class="row small-spacing">
        <div class="col-xs-12">
            <div class="box-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Pages</h3>
                    <a href="{{ route('admin.cms-pages.create') }}" class="btn btn-primary">
                        <i class="ri-add-box-line"></i> Add Page
                    </a>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('admin.cms-pages.index') }}" method="GET" class="row g-3">
                            <div class="col-md-9">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="is_active" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $key => $page)
                                <tr id="row_{{ $key }}">
                                    <td><strong>{{ $page->title }}</strong></td>
                                    <td><code>/{{ $page->slug }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $page->is_active ? 'success' : 'secondary' }}">
                                            {{ $page->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $page->updated_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.cms-pages.show', $page->id) }}" class="btn btn-info btn-sm">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.cms-pages.edit', $page->id) }}" class="btn btn-primary btn-sm">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button onclick="toggleStatus('{{ route('admin.cms-pages.toggle-status', $page->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $page->is_active ? 'true' : 'false' }})" class="btn btn-{{ $page->is_active ? 'warning' : 'success' }} btn-sm">
                                                <i class="ri-{{ $page->is_active ? 'pause' : 'play' }}-line"></i>
                                            </button>
                                            <button onclick="confirmDelete('{{ route('admin.cms-pages.destroy', $page->id) }}', {{ $key }}, '{{ csrf_token() }}')" class="btn btn-danger btn-sm">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">No pages found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $pages->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>
@endsection

