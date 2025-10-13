@extends('admin.layouts.main')
@section('title', 'Subscribers')

@section('content')
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $stats['total'] }}</h3>
                    <p class="text-muted mb-0">Total Subscribers</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $stats['active'] }}</h3>
                    <p class="text-muted mb-0">Active</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-info">{{ $stats['email_opt_in'] }}</h3>
                    <p class="text-muted mb-0">Email Opt-in</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-primary">{{ $stats['whatsapp_opt_in'] }}</h3>
                    <p class="text-muted mb-0">WhatsApp Opt-in</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="box-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Subscribers</h3>
                    <div class="btn-group">
                        <a href="{{ route('admin.subscribers.create') }}" class="btn btn-primary">
                            <i class="ri-add-box-line"></i> Add Subscriber
                        </a>
                        <a href="{{ route('admin.subscribers.export') }}" class="btn btn-success">
                            <i class="ri-download-line"></i> Export CSV
                        </a>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('admin.subscribers.index') }}" method="GET" class="row g-3">
                            <div class="col-md-5">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="unsubscribed" {{ request('status') == 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="city" class="form-select">
                                    <option value="">All Cities</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Membership</th>
                                <th>Opt-ins</th>
                                <th>Status</th>
                                <th>Subscribed</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscribers as $key => $subscriber)
                                <tr id="row_{{ $key }}">
                                    <td>{{ $subscriber->name ?? 'N/A' }}</td>
                                    <td>{{ $subscriber->email }}</td>
                                    <td>{{ $subscriber->city ?? 'N/A' }}</td>
                                    <td>{{ $subscriber->membership_status ?? 'N/A' }}</td>
                                    <td>
                                        @if($subscriber->email_opt_in)
                                            <span class="badge bg-info">Email</span>
                                        @endif
                                        @if($subscriber->whatsapp_opt_in)
                                            <span class="badge bg-success">WhatsApp</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $subscriber->status == 'active' ? 'success' : ($subscriber->status == 'inactive' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($subscriber->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $subscriber->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a href="{{ route('admin.subscribers.show', $subscriber->id) }}" class="btn btn-info btn-sm">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.subscribers.edit', $subscriber->id) }}" class="btn btn-primary btn-sm">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button onclick="toggleStatus('{{ route('admin.subscribers.toggle-status', $subscriber->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $subscriber->status == 'active' ? 'true' : 'false' }})" class="btn btn-{{ $subscriber->status == 'active' ? 'warning' : 'success' }} btn-sm">
                                                <i class="ri-{{ $subscriber->status == 'active' ? 'pause' : 'play' }}-line"></i>
                                            </button>
                                            <button onclick="confirmDelete('{{ route('admin.subscribers.destroy', $subscriber->id) }}', {{ $key }}, '{{ csrf_token() }}')" class="btn btn-danger btn-sm">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center">No subscribers found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $subscribers->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>
@endsection

