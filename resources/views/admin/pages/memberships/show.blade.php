@extends('admin.layouts.main')
@section('title', 'Membership Plan Details')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="border-top: 4px solid {{ $membership->color_theme }}">
                <div class="card-body text-center">
                    <h3>{{ $membership->name }}</h3>
                    <span class="badge mb-3" style="background: {{ $membership->color_theme }}">{{ $membership->tier_name }}</span>
                    <h2 class="text-primary">${{ number_format($membership->price, 2) }}</h2>
                    <p class="text-muted">{{ $membership->duration_days }} days</p>
                    @if($membership->description)
                        <p>{{ $membership->description }}</p>
                    @endif
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('admin.memberships.edit', $membership->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('admin.memberships.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3>{{ $stats['total_members'] }}</h3>
                            <p class="text-muted mb-0">Total Members</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3>{{ $stats['active_members'] }}</h3>
                            <p class="text-muted mb-0">Active Members</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3>${{ number_format($stats['revenue'], 2) }}</h3>
                            <p class="text-muted mb-0">Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
            @if($membership->benefits && count($membership->benefits) > 0)
                <div class="card">
                    <div class="card-header"><h4>Benefits</h4></div>
                    <div class="card-body">
                        <ul>
                            @foreach($membership->benefits as $benefit)
                                <li>{{ $benefit }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

