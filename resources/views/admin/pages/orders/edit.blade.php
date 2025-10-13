@extends('admin.layouts.main')
@section('title', 'Edit Order')
@section('content')
    <h4>Edit Order #{{ $order->order_number }}</h4>
    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label>Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="status" required>
                        @foreach(['pending', 'processing', 'completed', 'cancelled', 'refunded'] as $s)
                            <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Shipping Address</label>
                    <textarea class="form-control" name="shipping_address" rows="3">{{ $order->shipping_address }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" rows="2">{{ $order->notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
@endsection

