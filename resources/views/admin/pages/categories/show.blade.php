@extends('admin.layouts.main')
@section('title')
    Category Details - {{ $category->name }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line"></i> Edit Category
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back to List
                        </a>
                    </div>
                </div>
                <h4 class="page-title">Category Details</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Category Info Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="img-fluid rounded mb-3"
                             style="max-height: 200px; width: 100%; object-fit: cover;">
                    @else
                        <div class="mb-3" style="height: 200px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                            <div class="text-center">
                                <i class="ri-image-line" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">No Image</p>
                            </div>
                        </div>
                    @endif

                    <h4 class="mb-1">{{ $category->name }}</h4>
                    <p class="text-muted mb-2"><code>{{ $category->slug }}</code></p>
                    
                    <div class="mb-3">
                        <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }} fs-6">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge bg-info fs-6">
                            Sort: {{ $category->sort_order ?? 0 }}
                        </span>
                    </div>

                    <hr>

                    <div class="text-start">
                        @if($category->description)
                            <p class="mb-2">
                                <i class="ri-file-text-line me-2"></i>
                                <strong>Description:</strong><br>
                                <small class="text-muted">{{ $category->description }}</small>
                            </p>
                        @endif
                        <p class="mb-2">
                            <i class="ri-calendar-line me-2"></i>
                            <strong>Created:</strong> {{ $category->created_at->format('M d, Y') }}
                        </p>
                        <p class="mb-0">
                            <i class="ri-refresh-line me-2"></i>
                            <strong>Updated:</strong> {{ $category->updated_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Statistics -->
        <div class="col-md-8">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-shopping-bag-line widget-icon bg-primary-lighten text-primary"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Total Products">Total Products</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['total_products'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">All products in this category</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-checkbox-circle-line widget-icon bg-success-lighten text-success"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Active Products">Active Products</h5>
                            <h3 class="mt-3 mb-3">{{ $stats['active_products'] }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-nowrap">Currently available products</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products in this Category -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Products in this Category</h4>
                </div>
                <div class="card-body">
                    @if($category->products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->products->take(10) as $product)
                                        <tr>
                                            <td>
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <div style="width: 40px; height: 40px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                                        <i class="ri-image-line"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                            </td>
                                            <td>
                                                @if($product->price)
                                                    <span class="fw-bold text-success">${{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->stock_quantity !== null)
                                                    <span class="badge bg-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                                                        {{ $product->stock_quantity }} in stock
                                                    </span>
                                                @else
                                                    <span class="text-muted">Unlimited</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $product->created_at->format('M d, Y') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($category->products->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Showing first 10 products. Total: {{ $category->products->count() }}</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="ri-shopping-bag-line" style="font-size: 48px; color: #dee2e6;"></i>
                            <p class="text-muted mb-0 mt-2">No products in this category yet.</p>
                            <a href="{{ route('admin.products.create') }}?category={{ $category->id }}" class="btn btn-primary btn-sm mt-2">
                                <i class="ri-add-line"></i> Add Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Category Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('admin.products.create') }}?category={{ $category->id }}" class="btn btn-primary w-100">
                                <i class="ri-add-line"></i> Add Product
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" class="btn btn-info w-100">
                                <i class="ri-list-check"></i> View All Products
                            </a>
                        </div>
                        <div class="col-md-4">
                            <button type="button"
                                onclick="toggleStatus('{{ route('admin.categories.toggle-status', $category->id) }}', 0, '{{ csrf_token() }}', {{ $category->is_active ? 'true' : 'false' }})"
                                class="btn btn-{{ $category->is_active ? 'warning' : 'success' }} w-100">
                                <i class="ri-{{ $category->is_active ? 'pause' : 'play' }}-line"></i>
                                {{ $category->is_active ? 'Deactivate' : 'Activate' }}
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

