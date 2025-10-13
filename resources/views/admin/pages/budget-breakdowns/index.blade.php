@extends('admin.layouts.main')
@section('title', 'Budget Breakdowns')
@section('content')
    <div class="box-content">
        <div class="d-flex justify-content-between mb-3">
            <h3>Budget Breakdowns</h3>
            <a href="{{ route('admin.budget-breakdowns.create') }}" class="btn btn-primary"><i class="ri-add-line"></i> Add Budget</a>
        </div>
        <form action="{{ route('admin.budget-breakdowns.index') }}" method="GET" class="row g-3 mb-3">
            <div class="col-md-10">
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
                <tr><th>Project</th><th>Category</th><th>Description</th><th>Amount</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($budgets as $key => $budget)
                    <tr id="row_{{ $key }}">
                        <td>{{ $budget->project->title ?? 'N/A' }}</td>
                        <td><strong>{{ $budget->category }}</strong></td>
                        <td>{{ Str::limit($budget->description, 50) }}</td>
                        <td>${{ number_format($budget->amount, 2) }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.budget-breakdowns.edit', $budget->id) }}" class="btn btn-sm btn-primary"><i class="ri-edit-line"></i></a>
                                <button onclick="confirmDelete('{{ route('admin.budget-breakdowns.destroy', $budget->id) }}', {{ $key }}, '{{ csrf_token() }}')" class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No budget items found</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $budgets->links() }}
    </div>
@endsection
@section('scripts')<script src="{{ asset('assets/js/ajax-delete.js') }}"></script>@endsection

