@extends('admin.layouts.main')
@section('title')
    User Details - {{ $user->name }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <div class="btn-group">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line"></i> Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back to List
                        </a>
                    </div>
                </div>
                <h4 class="page-title">User Details</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Profile Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle mb-3 mx-auto" 
                             style="width: 150px; height: 150px; background: #007bff; color: white; display: flex; align-items: center; justify-content: center; font-size: 48px; font-weight: bold;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    
                    <div class="mb-3">
                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'moderator' ? 'warning' : 'info') }} fs-6">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }} fs-6">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <hr>

                    <div class="text-start">
                        <p class="mb-2">
                            <i class="ri-phone-line me-2"></i>
                            <strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}
                        </p>
                        <p class="mb-2">
                            <i class="ri-map-pin-line me-2"></i>
                            <strong>Address:</strong> {{ $user->address ?? 'N/A' }}
                        </p>
                        <p class="mb-2">
                            <i class="ri-calendar-line me-2"></i>
                            <strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}
                        </p>
                        <p class="mb-0">
                            <i class="ri-refresh-line me-2"></i>
                            <strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Statistics -->
        <div class="col-md-8">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-money-dollar-circle-line widget-icon bg-success-lighten text-success"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Total Donations">Donations</h5>
                            <h3 class="mt-3 mb-3">${{ number_format($stats['total_donations'], 2) }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">{{ $user->donations()->count() }} donations</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-shopping-cart-line widget-icon bg-info-lighten text-info"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Total Orders">Orders</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['total_orders'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">${{ number_format($stats['total_spent'], 2) }} spent</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-vip-crown-line widget-icon bg-warning-lighten text-warning"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Active Memberships">Memberships</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['active_memberships'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">{{ $user->userMemberships()->count() }} total</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-exchange-dollar-line widget-icon bg-primary-lighten text-primary"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Transactions">Transactions</h5>
                            <h3 class="mt-3 mb-3">{{ $user->transactions()->count() }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">All time</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Donations -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Donations</h4>
                </div>
                <div class="card-body">
                    @if($user->donations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Project</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->donations->take(5) as $donation)
                                        <tr>
                                            <td>{{ $donation->created_at->format('M d, Y') }}</td>
                                            <td>${{ number_format($donation->amount, 2) }}</td>
                                            <td>{{ $donation->project->name ?? 'General' }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ ucfirst($donation->status ?? 'completed') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No donations yet.</p>
                    @endif
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Orders</h4>
                </div>
                <div class="card-body">
                    @if($user->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->orders->take(5) as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No orders yet.</p>
                    @endif
                </div>
            </div>

            <!-- Memberships -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Memberships</h4>
                </div>
                <div class="card-body">
                    @if($user->userMemberships->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Plan</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->userMemberships->take(5) as $membership)
                                        <tr>
                                            <td>{{ $membership->membershipPlan->name ?? 'N/A' }}</td>
                                            <td>{{ $membership->start_date ? \Carbon\Carbon::parse($membership->start_date)->format('M d, Y') : 'N/A' }}</td>
                                            <td>{{ $membership->end_date ? \Carbon\Carbon::parse($membership->end_date)->format('M d, Y') : 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $membership->status == 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($membership->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No memberships yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

