@extends('admin.layouts.main')
@section('title', 'Order Details')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>Order #{{ $order->order_number }}</h4></div>
                <div class="card-body">
                    <table class="table">
                        <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr><th colspan="3">Subtotal</th><th>${{ number_format($order->subtotal, 2) }}</th></tr>
                            <tr><th colspan="3">Tax</th><th>${{ number_format($order->tax, 2) }}</th></tr>
                            <tr><th colspan="3">Shipping</th><th>${{ number_format($order->shipping, 2) }}</th></tr>
                            <tr class="table-active"><th colspan="3">Total</th><th>${{ number_format($order->total, 2) }}</th></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h4>Order Info</h4></div>
                <div class="card-body">
                    <p><strong>Customer:</strong> {{ $order->user->name ?? 'Guest' }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">{{ ucfirst($order->status) }}</span></p>
                    <p><strong>Payment:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary w-100">Edit</a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100 mt-2">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

