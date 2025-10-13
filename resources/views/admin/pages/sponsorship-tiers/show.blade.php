@extends('admin.layouts.main')
@section('title', 'Tier Details')
@section('content')
    <div class="card">
        <div class="card-body">
            <h3>{{ $sponsorshipTier->name }}</h3>
            <p>Project: {{ $sponsorshipTier->project->title ?? 'N/A' }}</p>
            <h4>${{ number_format($sponsorshipTier->amount, 2) }}</h4>
            <p>{{ $sponsorshipTier->description }}</p>
            @if($sponsorshipTier->benefits)
                <h5>Benefits:</h5>
                <ul>
                    @foreach($sponsorshipTier->benefits as $b)
                        <li>{{ $b }}</li>
                    @endforeach
                </ul>
            @endif
            <a href="{{ route('admin.sponsorship-tiers.edit', $sponsorshipTier->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.sponsorship-tiers.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection

