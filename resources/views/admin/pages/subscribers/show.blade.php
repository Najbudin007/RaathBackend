@extends('admin.layouts.main')
@section('title', 'Subscriber Details')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Subscriber Information</h4></div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $subscriber->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $subscriber->email }}</p>
                    <p><strong>City:</strong> {{ $subscriber->city ?? 'N/A' }}</p>
                    <p><strong>Membership Status:</strong> {{ $subscriber->membership_status ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $subscriber->status == 'active' ? 'success' : ($subscriber->status == 'inactive' ? 'warning' : 'danger') }}">
                            {{ ucfirst($subscriber->status) }}
                        </span>
                    </p>
                    <p><strong>Email Opt-in:</strong> {{ $subscriber->email_opt_in ? 'Yes' : 'No' }}</p>
                    <p><strong>WhatsApp Opt-in:</strong> {{ $subscriber->whatsapp_opt_in ? 'Yes' : 'No' }}</p>
                    <p><strong>Subscribed:</strong> {{ $subscriber->created_at->format('M d, Y H:i A') }}</p>
                    <div class="btn-group mt-3">
                        <a href="{{ route('admin.subscribers.edit', $subscriber->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('admin.subscribers.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

