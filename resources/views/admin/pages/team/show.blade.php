@extends('admin.layouts.main')
@section('title', 'Team Member Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <div class="btn-group">
                        <a href="{{ route('admin.team.edit', $team->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line"></i> Edit
                        </a>
                        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back
                        </a>
                    </div>
                </div>
                <h4 class="page-title">Team Member Details</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    @if($team->image)
                        <img src="{{ asset('storage/' . $team->image) }}" alt="{{ $team->name }}" 
                             class="rounded-circle img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="mb-3" style="width: 200px; height: 200px; margin: 0 auto; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="ri-user-line" style="font-size: 64px; color: #6c757d;"></i>
                        </div>
                    @endif

                    <h4>{{ $team->name }}</h4>
                    <p class="text-muted">{{ $team->position }}</p>
                    
                    <span class="badge bg-{{ $team->is_active ? 'success' : 'secondary' }} fs-6">
                        {{ $team->is_active ? 'Active' : 'Inactive' }}
                    </span>

                    <hr>

                    @if($team->email || $team->phone)
                        <div class="text-start">
                            @if($team->email)
                                <p><i class="ri-mail-line me-2"></i> {{ $team->email }}</p>
                            @endif
                            @if($team->phone)
                                <p><i class="ri-phone-line me-2"></i> {{ $team->phone }}</p>
                            @endif
                        </div>
                    @endif

                    @if($team->facebook || $team->twitter || $team->linkedin)
                        <hr>
                        <div class="d-flex justify-content-center gap-2">
                            @if($team->facebook)
                                <a href="{{ $team->facebook }}" target="_blank" class="btn btn-primary">
                                    <i class="ri-facebook-fill"></i>
                                </a>
                            @endif
                            @if($team->twitter)
                                <a href="{{ $team->twitter }}" target="_blank" class="btn btn-info">
                                    <i class="ri-twitter-fill"></i>
                                </a>
                            @endif
                            @if($team->linkedin)
                                <a href="{{ $team->linkedin }}" target="_blank" class="btn btn-primary">
                                    <i class="ri-linkedin-fill"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            @if($team->bio)
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Biography</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ $team->bio }}</p>
                    </div>
                </div>
            @endif

            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Additional Information</h4>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Sort Order:</dt>
                        <dd class="col-sm-9">{{ $team->sort_order ?? 0 }}</dd>

                        <dt class="col-sm-3">Created:</dt>
                        <dd class="col-sm-9">{{ $team->created_at->format('M d, Y H:i A') }}</dd>

                        <dt class="col-sm-3">Updated:</dt>
                        <dd class="col-sm-9">{{ $team->updated_at->format('M d, Y H:i A') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button"
                                onclick="toggleStatus('{{ route('admin.team.toggle-status', $team->id) }}', 0, '{{ csrf_token() }}', {{ $team->is_active ? 'true' : 'false' }})"
                                class="btn btn-{{ $team->is_active ? 'warning' : 'success' }} w-100">
                                <i class="ri-{{ $team->is_active ? 'pause' : 'play' }}-line"></i>
                                {{ $team->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button"
                                onclick="confirmDelete('{{ route('admin.team.destroy', $team->id) }}', 0, '{{ csrf_token() }}')"
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
@endsection

