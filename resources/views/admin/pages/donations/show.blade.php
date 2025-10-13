@extends('admin.layouts.main')
@section('title', 'Donation Details')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Donation Information</h4></div>
                <div class="card-body">
                    <h3 class="text-success">${{ number_format($donation->amount, 2) }}</h3>
                    <p><strong>Donor:</strong> {{ $donation->donor_name }}
                        @if($donation->is_anonymous)
                            <span class="badge bg-secondary">Anonymous</span>
                        @endif
                    </p>
                    <p><strong>Email:</strong> {{ $donation->donor_email }}</p>
                    @if($donation->donor_phone)
                        <p><strong>Phone:</strong> {{ $donation->donor_phone }}</p>
                    @endif
                    @if($donation->project)
                        <p><strong>Project:</strong> {{ $donation->project->title }}</p>
                    @endif
                    <p><strong>Payment Method:</strong> <span class="badge bg-info">{{ ucfirst($donation->payment_method) }}</span></p>
                    @if($donation->transaction_id)
                        <p><strong>Transaction ID:</strong> <code>{{ $donation->transaction_id }}</code></p>
                    @endif
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $donation->status == 'completed' ? 'success' : ($donation->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </p>
                    @if($donation->message)
                        <p><strong>Message:</strong><br>{{ $donation->message }}</p>
                    @endif
                    <p><strong>Date:</strong> {{ $donation->created_at->format('M d, Y H:i A') }}</p>
                    
                    <div class="btn-group mt-3">
                        <a href="{{ route('admin.donations.edit', $donation->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

