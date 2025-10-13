@extends('admin.layouts.main')
@section('title')
    Project Management
@stop

@section('styles')
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@stop

@section('content')
    <div class="row small-spacing">
        <div class="col-xs-12">
            <div class="box-content">
                <div class="clearfix bg-lighter">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">Project List</h3>
                        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                            <i class="ri-add-box-line"></i> Add New Project
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('admin.projects.index') }}" method="GET" class="row g-3">
                            <div class="col-md-5">
                                <input type="text" name="search" class="form-control" placeholder="Search by title, slug, or description..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="planning" {{ request('status') == 'planning' ? 'selected' : '' }}>Planning</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="on-hold" {{ request('status') == 'on-hold' ? 'selected' : '' }}>On Hold</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="is_featured" class="form-select">
                                    <option value="">All Projects</option>
                                    <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                                    <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Regular</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="table-responsive">
                    <table id="project-datatable" class="table table-striped table-bordered display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Project</th>
                                <th>Funding Progress</th>
                                <th>Timeline</th>
                                <th>Status</th>
                                <th>Stats</th>
                                <th>Featured</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $key => $project)
                                <tr id="row_{{ $key }}">
                                    <td>
                                        @if($project->image)
                                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div style="width: 80px; height: 60px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                                <i class="ri-image-line"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $project->title }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($project->short_description, 50) }}</small>
                                        <br>
                                        <code class="small">{{ $project->slug }}</code>
                                    </td>
                                    <td style="min-width: 200px;">
                                        <div class="mb-1">
                                            <small class="text-muted">
                                                ${{ number_format($project->collected_amount, 0) }} / 
                                                ${{ number_format($project->target_amount, 0) }}
                                            </small>
                                        </div>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $project->progress_percentage >= 100 ? 'success' : ($project->progress_percentage >= 50 ? 'info' : 'warning') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ min($project->progress_percentage, 100) }}%"
                                                 aria-valuenow="{{ $project->progress_percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ number_format($project->progress_percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="ri-calendar-line"></i> 
                                            {{ $project->start_date->format('M d, Y') }}
                                            <br>
                                            <i class="ri-calendar-check-line"></i> 
                                            {{ $project->end_date->format('M d, Y') }}
                                            <br>
                                            @if($project->days_remaining > 0)
                                                <span class="badge bg-info">{{ $project->days_remaining }} days left</span>
                                            @elseif($project->days_remaining == 0)
                                                <span class="badge bg-warning">Ends today</span>
                                            @else
                                                <span class="badge bg-danger">Ended {{ abs($project->days_remaining) }} days ago</span>
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'planning' => 'secondary',
                                                'active' => 'success',
                                                'on-hold' => 'warning',
                                                'completed' => 'info',
                                                'cancelled' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$project->status] ?? 'secondary' }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="ri-hand-heart-line"></i> {{ $project->donations_count }} donations
                                            <br>
                                            <i class="ri-award-line"></i> {{ $project->sponsorship_tiers_count }} tiers
                                            <br>
                                            <i class="ri-pie-chart-line"></i> {{ $project->budget_breakdowns_count }} budgets
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $project->is_featured ? 'warning' : 'light' }}">
                                            {{ $project->is_featured ? 'Featured' : 'Regular' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical" role="group">
                                            <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button type="button"
                                                onclick="toggleFeatured('{{ route('admin.projects.toggle-featured', $project->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $project->is_featured ? 'true' : 'false' }})"
                                                class="btn btn-{{ $project->is_featured ? 'secondary' : 'warning' }} btn-sm" 
                                                title="{{ $project->is_featured ? 'Remove from Featured' : 'Make Featured' }}">
                                                <i class="ri-star-{{ $project->is_featured ? 'fill' : 'line' }}"></i>
                                            </button>
                                            <button type="button"
                                                onclick="confirmDelete('{{ route('admin.projects.destroy', $project->id) }}', {{ $key }}, '{{ csrf_token() }}')"
                                                class="btn btn-danger btn-sm" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No projects found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#project-datatable').DataTable({
                "paging": false,
                "info": false,
                "searching": false,
                "ordering": true,
                "responsive": true
            });
        });

        // Toggle featured function
        function toggleFeatured(url, key, token, currentStatus) {
            const action = currentStatus === 'true' ? 'unfeature' : 'feature';
            
            Swal.fire({
                title: `Are you sure?`,
                text: `Do you want to ${action} this project?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            '_token': token,
                            '_method': 'POST'
                        },
                        success: function (data) {
                            if (data.success) {
                                location.reload();
                                Swal.fire(
                                    'Success!',
                                    data.message || `Project ${action}d successfully.`,
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message || `Failed to ${action} project.`,
                                    'error'
                                );
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            let errorMessage = `Failed to ${action} project.`;
                            
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire(
                                'Error!',
                                errorMessage,
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection

