@extends('admin.layouts.main')
@section('title', 'Donations')

@section('content')
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $stats['total_donations'] }}</h3>
                    <p class="text-muted mb-0">Total Donations</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-success">${{ number_format($stats['total_amount'], 2) }}</h3>
                    <p class="text-muted mb-0">Total Amount</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-info">{{ $stats['completed_count'] }}</h3>
                    <p class="text-muted mb-0">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-warning">${{ number_format($stats['pending_amount'], 2) }}</h3>
                    <p class="text-muted mb-0">Pending</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="box-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Donations</h3>
                    <a href="{{ route('admin.donations.create') }}" class="btn btn-primary">
                        <i class="ri-add-box-line"></i> Add Donation
                    </a>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('admin.donations.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="project_id" class="form-select">
                                    <option value="">All Projects</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="payment_method" class="form-select">
                                    <option value="">All Payment Methods</option>
                                    <option value="esewa" {{ request('payment_method') == 'esewa' ? 'selected' : '' }}>eSewa</option>
                                    <option value="khalti" {{ request('payment_method') == 'khalti' ? 'selected' : '' }}>Khalti</option>
                                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
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
                                <th>Donor</th>
                                <th>Project</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Transaction ID</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donations as $key => $donation)
                                <tr id="row_{{ $key }}">
                                    <td>
                                        <strong>{{ $donation->donor_name }}</strong>
                                        @if($donation->is_anonymous)
                                            <span class="badge bg-secondary">Anonymous</span>
                                        @endif
                                        <br>
                                        <small>{{ $donation->donor_email }}</small>
                                    </td>
                                    <td>{{ $donation->project->title ?? 'General' }}</td>
                                    <td><strong class="text-success">${{ number_format($donation->amount, 2) }}</strong></td>
                                    <td><span class="badge bg-info">{{ ucfirst($donation->payment_method) }}</span></td>
                                    <td><code>{{ $donation->transaction_id ?? 'N/A' }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $donation->status == 'completed' ? 'success' : ($donation->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $donation->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a href="{{ route('admin.donations.show', $donation->id) }}" class="btn btn-info btn-sm">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.donations.edit', $donation->id) }}" class="btn btn-primary btn-sm">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button onclick="confirmDelete('{{ route('admin.donations.destroy', $donation->id) }}', {{ $key }}, '{{ csrf_token() }}')" class="btn btn-danger btn-sm">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center">No donations found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $donations->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>
@endsection

