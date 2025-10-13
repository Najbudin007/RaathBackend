@extends('admin.layouts.main')
@section('title', 'Membership Plans')

@section('content')
    <div class="row small-spacing">
        <div class="col-xs-12">
            <div class="box-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Membership Plans</h3>
                    <a href="{{ route('admin.memberships.create') }}" class="btn btn-primary">
                        <i class="ri-add-box-line"></i> Add Plan
                    </a>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('admin.memberships.index') }}" method="GET" class="row g-3">
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

                <div class="row">
                    @forelse($plans as $key => $plan)
                        <div class="col-md-4 mb-3" id="row_{{ $key }}">
                            <div class="card h-100" style="border-top: 4px solid {{ $plan->color_theme ?? '#007bff' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title mb-1">{{ $plan->name }}</h5>
                                            <span class="badge" style="background: {{ $plan->color_theme ?? '#007bff' }}">
                                                {{ $plan->tier_name }}
                                            </span>
                                        </div>
                                        <span class="badge bg-{{ $plan->is_active ? 'success' : 'secondary' }}">
                                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <h3 class="text-primary mb-0">${{ number_format($plan->price, 2) }}</h3>
                                        <small class="text-muted">{{ $plan->duration_days }} days</small>
                                    </div>

                                    @if($plan->description)
                                        <p class="text-muted small">{{ Str::limit($plan->description, 100) }}</p>
                                    @endif

                                    @if($plan->benefits && count($plan->benefits) > 0)
                                        <ul class="small mb-3">
                                            @foreach(array_slice($plan->benefits, 0, 3) as $benefit)
                                                <li>{{ $benefit }}</li>
                                            @endforeach
                                            @if(count($plan->benefits) > 3)
                                                <li class="text-muted">+{{ count($plan->benefits) - 3 }} more...</li>
                                            @endif
                                        </ul>
                                    @endif

                                    <div class="mb-2">
                                        <small><i class="ri-user-line"></i> {{ $plan->user_memberships_count ?? 0 }} members</small>
                                    </div>

                                    <div class="btn-group w-100">
                                        <a href="{{ route('admin.memberships.show', $plan->id) }}" class="btn btn-sm btn-info">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="{{ route('admin.memberships.edit', $plan->id) }}" class="btn btn-sm btn-primary">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <button onclick="toggleStatus('{{ route('admin.memberships.toggle-status', $plan->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $plan->is_active ? 'true' : 'false' }})" class="btn btn-sm btn-{{ $plan->is_active ? 'warning' : 'success' }}">
                                            <i class="ri-{{ $plan->is_active ? 'pause' : 'play' }}-line"></i>
                                        </button>
                                        <button onclick="confirmDelete('{{ route('admin.memberships.destroy', $plan->id) }}', {{ $key }}, '{{ csrf_token() }}')" class="btn btn-sm btn-danger">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">No membership plans found</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-3">{{ $plans->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>
@endsection

