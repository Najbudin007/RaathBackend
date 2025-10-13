@extends('admin.layouts.main')
@section('title')
    Yatra Management
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
                        <h3 class="mb-0">Yatra List</h3>
                        <a href="{{ route('admin.yatras.create') }}" class="btn btn-primary">
                            <i class="ri-add-box-line"></i> Add New Yatra
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('admin.yatras.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Search by title, city, description..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="city" class="form-select">
                                    <option value="">All Cities</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="month" class="form-select">
                                    <option value="">All Months</option>
                                    @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="is_featured" class="form-select">
                                    <option value="">All Yatras</option>
                                    <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                                    <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Regular</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="table-responsive">
                    <table id="yatra-datatable" class="table table-striped table-bordered display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Yatra Details</th>
                                <th>Location</th>
                                <th>Timeline</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($yatras as $key => $yatra)
                                <tr id="row_{{ $key }}">
                                    <td>
                                        @if($yatra->image)
                                            <img src="{{ asset('storage/' . $yatra->image) }}" alt="{{ $yatra->title }}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div style="width: 80px; height: 60px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                                <i class="ri-image-line"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="min-width: 200px;">
                                        <strong>{{ $yatra->title }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($yatra->description, 60) }}</small>
                                        @if($yatra->month)
                                            <br>
                                            <span class="badge bg-secondary">{{ $yatra->month }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="ri-map-pin-line"></i> <strong>{{ $yatra->city }}</strong>
                                        @if($yatra->collaborating_center)
                                            <br>
                                            <small class="text-muted">{{ $yatra->collaborating_center }}</small>
                                        @endif
                                    </td>
                                    <td style="min-width: 150px;">
                                        <small>
                                            <i class="ri-calendar-line"></i> 
                                            {{ $yatra->start_date->format('M d, Y') }}
                                            <br>
                                            <i class="ri-calendar-check-line"></i> 
                                            {{ $yatra->end_date->format('M d, Y') }}
                                            <br>
                                            @php
                                                $daysUntil = $yatra->getDaysUntilStart();
                                            @endphp
                                            @if($daysUntil !== null)
                                                @if($daysUntil > 0)
                                                    <span class="badge bg-info">Starts in {{ $daysUntil }} days</span>
                                                @elseif($daysUntil == 0)
                                                    <span class="badge bg-success">Starts today</span>
                                                @else
                                                    <span class="badge bg-secondary">Started {{ abs($daysUntil) }} days ago</span>
                                                @endif
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'upcoming' => 'info',
                                                'ongoing' => 'success',
                                                'completed' => 'secondary',
                                                'cancelled' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$yatra->status] ?? 'secondary' }}">
                                            {{ ucfirst($yatra->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $yatra->is_featured ? 'warning' : 'light' }}">
                                            {{ $yatra->is_featured ? 'Featured' : 'Regular' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical" role="group">
                                            <a href="{{ route('admin.yatras.show', $yatra->id) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.yatras.edit', $yatra->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button type="button"
                                                onclick="toggleFeatured('{{ route('admin.yatras.toggle-featured', $yatra->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $yatra->is_featured ? 'true' : 'false' }})"
                                                class="btn btn-{{ $yatra->is_featured ? 'secondary' : 'warning' }} btn-sm" 
                                                title="{{ $yatra->is_featured ? 'Remove from Featured' : 'Make Featured' }}">
                                                <i class="ri-star-{{ $yatra->is_featured ? 'fill' : 'line' }}"></i>
                                            </button>
                                            <button type="button"
                                                onclick="confirmDelete('{{ route('admin.yatras.destroy', $yatra->id) }}', {{ $key }}, '{{ csrf_token() }}')"
                                                class="btn btn-danger btn-sm" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No yatras found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $yatras->links() }}
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
            $('#yatra-datatable').DataTable({
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
                text: `Do you want to ${action} this yatra?`,
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
                                    data.message || `Yatra ${action}d successfully.`,
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message || `Failed to ${action} yatra.`,
                                    'error'
                                );
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            let errorMessage = `Failed to ${action} yatra.`;
                            
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

