@extends('admin.layouts.main')
@section('title')
    Product Management
@stop

@section('styles')
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@stop

@section('content')
    <div class="row small-spacing">
        <div class="col-xs-12">
            <div class="box-content">
                <div class="clearfix bg-lighter">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">Product List</h3>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="ri-add-box-line"></i> Add New Product
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Search by name, slug, or description..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="category_id" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="is_active" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="is_featured" class="form-select">
                                    <option value="">All Products</option>
                                    <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                                    <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Regular</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="table-responsive">
                    <table id="product-datatable" class="table table-striped table-bordered display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $key => $product)
                                <tr id="row_{{ $key }}">
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div style="width: 60px; height: 60px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                                <i class="ri-image-line"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                        <br>
                                        <code class="small">{{ $product->slug }}</code>
                                    </td>
                                    <td>
                                        @if($product->category)
                                            <span class="badge bg-info">{{ $product->category->name }}</span>
                                        @else
                                            <span class="text-muted">No Category</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                                            @if($product->sale_price && $product->sale_price < $product->price)
                                                <br>
                                                <small class="text-danger">
                                                    <del>${{ number_format($product->price, 2) }}</del>
                                                    <strong>${{ number_format($product->sale_price, 2) }}</strong>
                                                </small>
                                                <br>
                                                <span class="badge bg-danger">Sale!</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($product->stock_quantity !== null)
                                            <span class="badge bg-{{ $product->stock_quantity > 0 ? ($product->stock_quantity > 10 ? 'success' : 'warning') : 'danger' }}">
                                                {{ $product->stock_quantity }} in stock
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Unlimited</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $product->is_featured ? 'warning' : 'light' }}">
                                            {{ $product->is_featured ? 'Featured' : 'Regular' }}
                                        </span>
                                    </td>
                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button type="button"
                                                onclick="toggleStatus('{{ route('admin.products.toggle-status', $product->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $product->is_active ? 'true' : 'false' }})"
                                                class="btn btn-{{ $product->is_active ? 'warning' : 'success' }} btn-sm" 
                                                title="{{ $product->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="ri-{{ $product->is_active ? 'pause' : 'play' }}-line"></i>
                                            </button>
                                            <button type="button"
                                                onclick="toggleFeatured('{{ route('admin.products.toggle-featured', $product->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $product->is_featured ? 'true' : 'false' }})"
                                                class="btn btn-{{ $product->is_featured ? 'secondary' : 'warning' }} btn-sm" 
                                                title="{{ $product->is_featured ? 'Remove from Featured' : 'Make Featured' }}">
                                                <i class="ri-star-{{ $product->is_featured ? 'fill' : 'line' }}"></i>
                                            </button>
                                            <button type="button"
                                                onclick="confirmDelete('{{ route('admin.products.destroy', $product->id) }}', {{ $key }}, '{{ csrf_token() }}')"
                                                class="btn btn-danger btn-sm" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No products found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#product-datatable').DataTable({
                "paging": false,
                "info": false,
                "searching": false,
                "ordering": true,
                "responsive": true
            });
        });

        // Toggle featured function
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

