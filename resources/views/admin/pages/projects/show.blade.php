@extends('admin.layouts.main')
@section('title')
    Project Details - {{ $project->title }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <div class="btn-group">
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line"></i> Edit Project
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back to List
                        </a>
                    </div>
                </div>
                <h4 class="page-title">Project Details</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Project Info Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" 
                             alt="{{ $project->title }}" 
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

                    <h4 class="mb-1">{{ $project->title }}</h4>
                    <p class="text-muted mb-2"><code>{{ $project->slug }}</code></p>
                    
                    <div class="mb-3">
                        @php
                            $statusColors = [
                                'planning' => 'secondary',
                                'active' => 'success',
                                'on-hold' => 'warning',
                                'completed' => 'info',
                                'cancelled' => 'danger'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$project->status] ?? 'secondary' }} fs-6">
                            {{ ucfirst($project->status) }}
                        </span>
                        @if($project->is_featured)
                            <span class="badge bg-warning fs-6">Featured</span>
                        @endif
                    </div>

                    <hr>

                    <!-- Funding Progress -->
                    <div class="mb-3">
                        <h5 class="text-success mb-2">
                            <i class="ri-money-dollar-circle-line me-2"></i>
                            Funding Progress
                        </h5>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between">
                                <span>${{ number_format($project->collected_amount, 0) }}</span>
                                <span>${{ number_format($project->target_amount, 0) }}</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-{{ $stats['progress_percentage'] >= 100 ? 'success' : ($stats['progress_percentage'] >= 50 ? 'info' : 'warning') }}" 
                                     role="progressbar" 
                                     style="width: {{ min($stats['progress_percentage'], 100) }}%"
                                     aria-valuenow="{{ $stats['progress_percentage'] }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ number_format($stats['progress_percentage'], 1) }}%
                                </div>
                            </div>
                        </div>
                        @if($project->budget)
                            <p class="mb-0 text-muted">
                                <strong>Total Budget:</strong> ${{ number_format($project->budget, 2) }}
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
                            <strong>Start:</strong> {{ $project->start_date->format('M d, Y') }}
                        </p>
                        <p class="mb-1">
                            <strong>End:</strong> {{ $project->end_date->format('M d, Y') }}
                        </p>
                        <p class="mb-0">
                            @if($stats['days_remaining'] > 0)
                                <span class="badge bg-info">{{ $stats['days_remaining'] }} days remaining</span>
                            @elseif($stats['days_remaining'] == 0)
                                <span class="badge bg-warning">Ends today</span>
                            @else
                                <span class="badge bg-danger">Ended {{ abs($stats['days_remaining']) }} days ago</span>
                            @endif
                        </p>
                    </div>

                    <hr>

                    <!-- Meta Information -->
                    <div>
                        <p class="mb-2">
                            <i class="ri-calendar-line me-2"></i>
                            <strong>Created:</strong> {{ $project->created_at->format('M d, Y') }}
                        </p>
                        <p class="mb-0">
                            <i class="ri-refresh-line me-2"></i>
                            <strong>Updated:</strong> {{ $project->updated_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Gallery Images -->
            @if($project->images && count($project->images) > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Gallery Images</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($project->images as $index => $image)
                                <div class="col-md-6 mb-2">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image {{ $index + 1 }}" 
                                         class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Design Documents -->
            @if($project->design_docs && count($project->design_docs) > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Design Documents</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($project->design_docs as $doc)
                                <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="list-group-item list-group-item-action">
                                    <i class="ri-file-line me-2"></i> {{ basename($doc) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Project Details & Statistics -->
        <div class="col-md-8">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-hand-heart-line widget-icon bg-primary-lighten text-primary"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Total Donations">Donations</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['total_donations'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">${{ number_format($stats['total_donated'], 0) }} donated</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-award-line widget-icon bg-success-lighten text-success"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Sponsorship Tiers">Tiers</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['total_sponsors'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">Sponsorship levels</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-pie-chart-line widget-icon bg-info-lighten text-info"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Budget Items">Budget</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['budget_items'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">Budget breakdowns</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-percent-line widget-icon bg-warning-lighten text-warning"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Progress">Progress</h5>
                            <h3 class="mt-3 mb-3">{{ number_format($stats['progress_percentage'], 1) }}%</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">Funding progress</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Project Description</h4>
                </div>
                <div class="card-body">
                    @if($project->short_description)
                        <p class="text-muted"><em>{{ $project->short_description }}</em></p>
                        <hr>
                    @endif
                    <div>{!! nl2br(e($project->description)) !!}</div>
                </div>
            </div>

            <!-- Vision & Goals -->
            @if($project->vision)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Vision & Goals</h4>
                    </div>
                    <div class="card-body">
                        <div>{!! nl2br(e($project->vision)) !!}</div>
                    </div>
                </div>
            @endif

            <!-- Technical Specifications -->
            @if($project->technical_specs)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Technical Specifications</h4>
                    </div>
                    <div class="card-body">
                        <div>{!! nl2br(e($project->technical_specs)) !!}</div>
                    </div>
                </div>
            @endif

            <!-- Sponsorship Tiers -->
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Sponsorship Tiers</h4>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="ri-add-line"></i> Add Tier
                    </a>
                </div>
                <div class="card-body">
                    @if($project->sponsorshipTiers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Tier Name</th>
                                        <th>Amount</th>
                                        <th>Benefits</th>
                                        <th>Subscribers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->sponsorshipTiers as $tier)
                                        <tr>
                                            <td><strong>{{ $tier->name }}</strong></td>
                                            <td>${{ number_format($tier->amount, 2) }}</td>
                                            <td>{{ Str::limit($tier->benefits, 50) }}</td>
                                            <td><span class="badge bg-info">{{ $tier->subscribers_count ?? 0 }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ri-award-line" style="font-size: 48px; color: #dee2e6;"></i>
                            <p class="text-muted mb-0 mt-2">No sponsorship tiers defined yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Budget Breakdowns -->
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Budget Breakdown</h4>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="ri-add-line"></i> Add Budget Item
                    </a>
                </div>
                <div class="card-body">
                    @if($project->budgetBreakdowns->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalBudget = $project->budgetBreakdowns->sum('amount'); @endphp
                                    @foreach($project->budgetBreakdowns as $budget)
                                        <tr>
                                            <td><strong>{{ $budget->category }}</strong></td>
                                            <td>{{ Str::limit($budget->description, 40) }}</td>
                                            <td>${{ number_format($budget->amount, 2) }}</td>
                                            <td>
                                                @if($totalBudget > 0)
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar" role="progressbar" 
                                                             style="width: {{ ($budget->amount / $totalBudget) * 100 }}%">
                                                            {{ number_format(($budget->amount / $totalBudget) * 100, 1) }}%
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="table-active">
                                        <td colspan="2"><strong>Total</strong></td>
                                        <td><strong>${{ number_format($totalBudget, 2) }}</strong></td>
                                        <td><strong>100%</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ri-pie-chart-line" style="font-size: 48px; color: #dee2e6;"></i>
                            <p class="text-muted mb-0 mt-2">No budget breakdown defined yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Donations -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Donations</h4>
                </div>
                <div class="card-body">
                    @if($project->donations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Donor</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->donations->take(10) as $donation)
                                        <tr>
                                            <td>{{ $donation->user->name ?? $donation->donor_name ?? 'Anonymous' }}</td>
                                            <td><strong>${{ number_format($donation->amount, 2) }}</strong></td>
                                            <td><span class="badge bg-secondary">{{ ucfirst($donation->type ?? 'donation') }}</span></td>
                                            <td>{{ $donation->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $donation->status == 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($donation->status ?? 'pending') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($project->donations->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Showing first 10 donations. Total: {{ $project->donations->count() }}</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="ri-hand-heart-line" style="font-size: 48px; color: #dee2e6;"></i>
                            <p class="text-muted mb-0 mt-2">No donations for this project yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Project Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button"
                                onclick="toggleFeatured('{{ route('admin.projects.toggle-featured', $project->id) }}', 0, '{{ csrf_token() }}', {{ $project->is_featured ? 'true' : 'false' }})"
                                class="btn btn-{{ $project->is_featured ? 'secondary' : 'warning' }} w-100">
                                <i class="ri-star-{{ $project->is_featured ? 'fill' : 'line' }}"></i>
                                {{ $project->is_featured ? 'Unfeature' : 'Feature' }}
                            </button>
                        </div>
                        <div class="col-md-4">
                            <div class="dropdown">
                                <button class="btn btn-info w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-settings-3-line"></i> Change Status
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('planning')">Planning</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('active')">Active</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('on-hold')">On Hold</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('completed')">Completed</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('cancelled')">Cancelled</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                onclick="confirmDelete('{{ route('admin.projects.destroy', $project->id) }}', 0, '{{ csrf_token() }}')"
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
                title: 'Update Project Status?',
                text: `Change status to ${status}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.projects.update-status', $project->id) }}",
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

