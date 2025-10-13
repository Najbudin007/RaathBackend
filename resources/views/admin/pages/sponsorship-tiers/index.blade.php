@extends('admin.layouts.main')
@section('title', 'Sponsorship Tiers')
@section('content')
    <div class="box-content">
        <div class="d-flex justify-content-between mb-3">
            <h3>Sponsorship Tiers</h3>
            <a href="{{ route('admin.sponsorship-tiers.create') }}" class="btn btn-primary"><i class="ri-add-line"></i> Add Tier</a>
        </div>
        <form action="{{ route('admin.sponsorship-tiers.index') }}" method="GET" class="row g-3 mb-3">
            <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"></div>
            <div class="col-md-4">
                <select name="project_id" class="form-select">
                    <option value="">All Projects</option>
                    @foreach($projects as $proj)
                        <option value="{{ $proj->id }}" {{ request('project_id') == $proj->id ? 'selected' : '' }}>{{ $proj->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr><th>Project</th><th>Name</th><th>Amount</th><th>Benefits</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($tiers as $key => $tier)
                    <tr id="row_{{ $key }}">
                        <td>{{ $tier->project->title ?? 'N/A' }}</td>
                        <td><strong>{{ $tier->name }}</strong></td>
                        <td>${{ number_format($tier->amount, 2) }}</td>
                        <td>{{ is_array($tier->benefits) ? count($tier->benefits) : 0 }} benefits</td>
                        <td><span class="badge bg-{{ $tier->is_active ? 'success' : 'secondary' }}">{{ $tier->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.sponsorship-tiers.show', $tier->id) }}" class="btn btn-sm btn-info"><i class="ri-eye-line"></i></a>
                                <a href="{{ route('admin.sponsorship-tiers.edit', $tier->id) }}" class="btn btn-sm btn-primary"><i class="ri-edit-line"></i></a>
                                <button onclick="toggleStatus('{{ route('admin.sponsorship-tiers.toggle-status', $tier->id) }}', {{ $key }}, '{{ csrf_token() }}', true)" class="btn btn-sm btn-warning"><i class="ri-pause-line"></i></button>
                                <button onclick="confirmDelete('{{ route('admin.sponsorship-tiers.destroy', $tier->id) }}', {{ $key }}, '{{ csrf_token() }}')" class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No tiers found</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $tiers->links() }}
    </div>
@endsection
@section('scripts')<script src="{{ asset('assets/js/ajax-delete.js') }}"></script>@endsection

