@extends('admin.layouts.main')
@section('title')
    Yatra Details - {{ $yatra->title }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <div class="btn-group">
                        <a href="{{ route('admin.yatras.edit', $yatra->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line"></i> Edit Yatra
                        </a>
                        <a href="{{ route('admin.yatras.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back to List
                        </a>
                    </div>
                </div>
                <h4 class="page-title">Yatra Details</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Yatra Info Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    @if($yatra->image)
                        <img src="{{ asset('storage/' . $yatra->image) }}" 
                             alt="{{ $yatra->title }}" 
                             class="img-fluid rounded mb-3"
                             style="max-height: 250px; width: 100%; object-fit: cover;">
                    @else
                        <div class="mb-3" style="height: 250px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                            <div class="text-center">
                                <i class="ri-image-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">No Image</p>
                            </div>
                        </div>
                    @endif

                    <h4 class="mb-1">{{ $yatra->title }}</h4>
                    
                    <div class="mb-3">
                        @php
                            $statusColors = [
                                'upcoming' => 'info',
                                'ongoing' => 'success',
                                'completed' => 'secondary',
                                'cancelled' => 'danger'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$yatra->status] ?? 'secondary' }} fs-6">
                            {{ ucfirst($yatra->status) }}
                        </span>
                        @if($yatra->is_featured)
                            <span class="badge bg-warning fs-6">Featured</span>
                        @endif
                        @if($yatra->month)
                            <span class="badge bg-secondary fs-6">{{ $yatra->month }}</span>
                        @endif
                    </div>

                    <hr>

                    <!-- Location Info -->
                    <div class="mb-3">
                        <h6>
                            <i class="ri-map-pin-line me-2"></i>
                            Location
                        </h6>
                        <p class="mb-1">
                            <strong>City:</strong> {{ $yatra->city }}
                        </p>
                        @if($yatra->collaborating_center)
                            <p class="mb-0">
                                <strong>Center:</strong> {{ $yatra->collaborating_center }}
                            </p>
                        @endif
                    </div>

                    <hr>

                    <!-- Timeline -->
                    <div class="mb-3">
                        <h6>
                            <i class="ri-calendar-line me-2"></i>
                            Timeline
                        </h6>
                        <p class="mb-1">
                            <strong>Start:</strong> {{ $yatra->start_date->format('l, F d, Y') }}
                        </p>
                        <p class="mb-1">
                            <strong>End:</strong> {{ $yatra->end_date->format('l, F d, Y') }}
                        </p>
                        <p class="mb-1">
                            <strong>Duration:</strong> {{ $stats['duration_days'] }} {{ Str::plural('day', $stats['duration_days']) }}
                        </p>
                        <p class="mb-0">
                            @if($stats['days_until_start'] !== null)
                                @if($stats['days_until_start'] > 0)
                                    <span class="badge bg-info">Starts in {{ $stats['days_until_start'] }} {{ Str::plural('day', $stats['days_until_start']) }}</span>
                                @elseif($stats['days_until_start'] == 0)
                                    <span class="badge bg-success">Starts today!</span>
                                @else
                                    <span class="badge bg-secondary">Started {{ abs($stats['days_until_start']) }} {{ Str::plural('day', abs($stats['days_until_start'])) }} ago</span>
                                @endif
                            @endif
                        </p>
                    </div>

                    <hr>

                    <!-- Meta Information -->
                    <div>
                        <p class="mb-2">
                            <i class="ri-calendar-line me-2"></i>
                            <strong>Created:</strong> {{ $yatra->created_at->format('M d, Y') }}
                        </p>
                        <p class="mb-0">
                            <i class="ri-refresh-line me-2"></i>
                            <strong>Updated:</strong> {{ $yatra->updated_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Yatra Details -->
        <div class="col-md-8">
            <!-- Description -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Yatra Description</h4>
                </div>
                <div class="card-body">
                    <div>{!! nl2br(e($yatra->description)) !!}</div>
                </div>
            </div>

            <!-- Additional Details -->
            @if($yatra->details && count($yatra->details) > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Additional Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Detail</th>
                                        <th>Information</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($yatra->details as $key => $value)
                                        <tr>
                                            <td><strong>{{ ucfirst($key) }}</strong></td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Statistics -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Yatra Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center p-3 border rounded">
                                <i class="ri-calendar-event-line" style="font-size: 36px; color: #007bff;"></i>
                                <h5 class="mt-2 mb-0">{{ $stats['duration_days'] }}</h5>
                                <p class="text-muted mb-0">Days Duration</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 border rounded">
                                <i class="ri-map-pin-line" style="font-size: 36px; color: #28a745;"></i>
                                <h5 class="mt-2 mb-0">{{ $yatra->city }}</h5>
                                <p class="text-muted mb-0">Destination</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 border rounded">
                                @if($stats['is_upcoming'])
                                    <i class="ri-time-line" style="font-size: 36px; color: #ffc107;"></i>
                                    <h5 class="mt-2 mb-0">Upcoming</h5>
                                    <p class="text-muted mb-0">Status</p>
                                @elseif($yatra->status == 'ongoing')
                                    <i class="ri-play-circle-line" style="font-size: 36px; color: #28a745;"></i>
                                    <h5 class="mt-2 mb-0">Ongoing</h5>
                                    <p class="text-muted mb-0">Status</p>
                                @elseif($yatra->status == 'completed')
                                    <i class="ri-checkbox-circle-line" style="font-size: 36px; color: #6c757d;"></i>
                                    <h5 class="mt-2 mb-0">Completed</h5>
                                    <p class="text-muted mb-0">Status</p>
                                @else
                                    <i class="ri-close-circle-line" style="font-size: 36px; color: #dc3545;"></i>
                                    <h5 class="mt-2 mb-0">{{ ucfirst($yatra->status) }}</h5>
                                    <p class="text-muted mb-0">Status</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yatra Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button"
                                onclick="toggleFeatured('{{ route('admin.yatras.toggle-featured', $yatra->id) }}', 0, '{{ csrf_token() }}', {{ $yatra->is_featured ? 'true' : 'false' }})"
                                class="btn btn-{{ $yatra->is_featured ? 'secondary' : 'warning' }} w-100">
                                <i class="ri-star-{{ $yatra->is_featured ? 'fill' : 'line' }}"></i>
                                {{ $yatra->is_featured ? 'Unfeature' : 'Feature' }}
                            </button>
                        </div>
                        <div class="col-md-4">
                            <div class="dropdown">
                                <button class="btn btn-info w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-settings-3-line"></i> Change Status
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('upcoming')">Upcoming</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('ongoing')">Ongoing</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('completed')">Completed</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('cancelled')">Cancelled</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                onclick="confirmDelete('{{ route('admin.yatras.destroy', $yatra->id) }}', 0, '{{ csrf_token() }}')"
                                class="btn btn-danger w-100">
                                <i class="ri-delete-bin-line"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>
    
    <script>
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
                        data: { '_token': token },
                        success: function (data) {
                            if (data.success) {
                                location.reload();
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        }
                    });
                }
            });
        }

        // Update status function
        function updateStatus(status) {
            Swal.fire({
                title: 'Update Yatra Status?',
                text: `Change status to ${status}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.yatras.update-status', $yatra->id) }}",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'status': status
                        },
                        success: function (data) {
                            if (data.success) {
                                location.reload();
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection

