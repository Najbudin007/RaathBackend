@extends('admin.layouts.main')
@section('title', 'Orders')
@section('content')
    <div class="row mb-3">
        @foreach([
            ['label' => 'Total Orders', 'value' => $stats['total_orders'], 'color' => 'primary'],
            ['label' => 'Revenue', 'value' => '$' . number_format($stats['total_revenue'], 2), 'color' => 'success'],
            ['label' => 'Pending', 'value' => $stats['pending_count'], 'color' => 'warning'],
            ['label' => 'Completed', 'value' => $stats['completed_count'], 'color' => 'info']
        ] as $stat)
            <div class="col-md-3">
                <div class="card"><div class="card-body text-center"><h3 class="text-{{ $stat['color'] }}">{{ $stat['value'] }}</h3><p class="text-muted mb-0">{{ $stat['label'] }}</p></div></div>
            </div>
        @endforeach
    </div>
    <div class="box-content">
        <h3 class="mb-3">Orders</h3>
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 mb-3">
            <div class="col-md-8"><input type="text" name="search" class="form-control" placeholder="Search order number, email, phone..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['pending', 'processing', 'completed', 'cancelled', 'refunded'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1"><button class="btn btn-primary w-100">Filter</button></div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr><th>Order #</th><th>Customer</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $key => $order)
                    <tr id="row_{{ $key }}">
                        <td><strong>#{{ $order->order_number }}</strong></td>
                        <td>{{ $order->user->name ?? 'Guest' }}<br><small>{{ $order->email }}</small></td>
                        <td>{{ $order->orderItems->count() }} items</td>
                        <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                        <td>{{ ucfirst($order->payment_method ?? 'N/A') }}</td>
                        <td><span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($order->status) }}</span></td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group-vertical">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info"><i class="ri-eye-line"></i></a>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-primary"><i class="ri-edit-line"></i></a>
                                <button onclick="confirmDelete('{{ route('admin.orders.destroy', $order->id) }}', {{ $key }}, '{{ csrf_token() }}')" class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">No orders found</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
@endsection
@section('scripts')<script src="{{ asset('assets/js/ajax-delete.js') }}"></script>@endsection

