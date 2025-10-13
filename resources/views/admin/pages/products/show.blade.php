@extends('admin.layouts.main')
@section('title')
    Product Details - {{ $product->name }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <div class="btn-group">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line"></i> Edit Product
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back to List
                        </a>
                    </div>
                </div>
                <h4 class="page-title">Product Details</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Product Info Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded mb-3"
                             style="max-height: 250px; width: 100%; object-fit: cover;">
                    @else
                        <div class="mb-3" style="height: 250px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                            <div class="text-center">
                                <i class="ri-image-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">No Image</p>
                            </div>
                        </div>
                    @endif

                    <h4 class="mb-1">{{ $product->name }}</h4>
                    <p class="text-muted mb-2"><code>{{ $product->slug }}</code></p>
                    
                    <div class="mb-3">
                        @if($product->category)
                            <span class="badge bg-info fs-6">{{ $product->category->name }}</span>
                        @endif
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }} fs-6">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($product->is_featured)
                            <span class="badge bg-warning fs-6">Featured</span>
                        @endif
                        <span class="badge bg-secondary fs-6">
                            Sort: {{ $product->sort_order ?? 0 }}
                        </span>
                    </div>

                    <hr>

                    <div class="text-start">
                        <h5 class="text-success mb-3">
                            <i class="ri-money-dollar-circle-line me-2"></i>
                            Price: ${{ number_format($product->price, 2) }}
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <br>
                                <small class="text-danger">
                                    <del>${{ number_format($product->price, 2) }}</del>
                                    <strong>${{ number_format($product->sale_price, 2) }}</strong>
                                    <span class="badge bg-danger ms-2">Sale!</span>
                                </small>
                            @endif
                        </h5>

                        @if($product->stock_quantity !== null)
                            <p class="mb-2">
                                <i class="ri-stock-line me-2"></i>
                                <strong>Stock:</strong> 
                                <span class="badge bg-{{ $product->stock_quantity > 0 ? ($product->stock_quantity > 10 ? 'success' : 'warning') : 'danger' }}">
                                    {{ $product->stock_quantity }} items
                                </span>
                            </p>
                        @else
                            <p class="mb-2">
                                <i class="ri-stock-line me-2"></i>
                                <strong>Stock:</strong> 
                                <span class="badge bg-secondary">Unlimited</span>
                            </p>
                        @endif

                        @if($product->description)
                            <p class="mb-2">
                                <i class="ri-file-text-line me-2"></i>
                                <strong>Description:</strong><br>
                                <small class="text-muted">{{ $product->description }}</small>
                            </p>
                        @endif

                        <p class="mb-2">
                            <i class="ri-calendar-line me-2"></i>
                            <strong>Created:</strong> {{ $product->created_at->format('M d, Y') }}
                        </p>
                        <p class="mb-0">
                            <i class="ri-refresh-line me-2"></i>
                            <strong>Updated:</strong> {{ $product->updated_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Gallery Images -->
            @if($product->images && count($product->images) > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Gallery Images</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($product->images as $index => $image)
                                <div class="col-md-6 mb-2">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image {{ $index + 1 }}" 
                                         class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Product Statistics -->
        <div class="col-md-8">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-shopping-cart-line widget-icon bg-primary-lighten text-primary"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Total Orders">Orders</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['total_orders'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">Total orders</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-shopping-bag-line widget-icon bg-success-lighten text-success"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Total Sold">Sold</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['total_sold'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">Units sold</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-money-dollar-circle-line widget-icon bg-info-lighten text-info"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Total Revenue">Revenue</h5>
                            <h3 class="mt-3 mb-3">${{ number_format($stats['total_revenue'], 2) }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">Total revenue</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-shopping-cart-2-line widget-icon bg-warning-lighten text-warning"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="In Carts">In Carts</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['in_carts'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">Currently in carts</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order History -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Orders</h4>
                </div>
                <div class="card-body">
                    @if($product->orderItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->orderItems->take(10) as $orderItem)
                                        <tr>
                                            <td>#{{ $orderItem->order_id }}</td>
                                            <td>{{ $orderItem->order->user->name ?? 'Guest' }}</td>
                                            <td>{{ $orderItem->quantity }}</td>
                                            <td>${{ number_format($orderItem->price, 2) }}</td>
                                            <td>${{ number_format($orderItem->total_price, 2) }}</td>
                                            <td>{{ $orderItem->order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $orderItem->order->status == 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($orderItem->order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($product->orderItems->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Showing first 10 orders. Total: {{ $product->orderItems->count() }}</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="ri-shopping-cart-line" style="font-size: 48px; color: #dee2e6;"></i>
                            <p class="text-muted mb-0 mt-2">No orders for this product yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button"
                                onclick="toggleStatus('{{ route('admin.products.toggle-status', $product->id) }}', 0, '{{ csrf_token() }}', {{ $product->is_active ? 'true' : 'false' }})"
                                class="btn btn-{{ $product->is_active ? 'warning' : 'success' }} w-100">
                                <i class="ri-{{ $product->is_active ? 'pause' : 'play' }}-line"></i>
                                {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button"
                                onclick="toggleFeatured('{{ route('admin.products.toggle-featured', $product->id) }}', 0, '{{ csrf_token() }}', {{ $product->is_featured ? 'true' : 'false' }})"
                                class="btn btn-{{ $product->is_featured ? 'secondary' : 'warning' }} w-100">
                                <i class="ri-star-{{ $product->is_featured ? 'fill' : 'line' }}"></i>
                                {{ $product->is_featured ? 'Unfeature' : 'Feature' }}
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.products.index') }}?category={{ $product->category_id }}" class="btn btn-info w-100">
                                <i class="ri-list-check"></i> View Category
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button type="button"
                                onclick="confirmDelete('{{ route('admin.products.destroy', $product->id) }}', 0, '{{ csrf_token() }}')"
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
    
    <script>
        // Toggle featured function (same as in index)
        function toggleFeatured(url, key, token, currentStatus) {
            const action = currentStatus === 'true' ? 'unfeature' : 'feature';
            
            Swal.fire({
                title: `Are you sure?`,
                text: `Do you want to ${action} this product?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            '_token': token,
                            '_method': 'POST'
                        },
                        success: function (data) {
                            if (data.success) {
                                location.reload();
                                Swal.fire(
                                    'Success!',
                                    data.message || `Product ${action}d successfully.`,
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message || `Failed to ${action} product.`,
                                    'error'
                                );
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            let errorMessage = `Failed to ${action} product.`;
                            
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire(
                                'Error!',
                                errorMessage,
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection

