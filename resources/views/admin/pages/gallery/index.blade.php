@extends('admin.layouts.main')
@section('title')
    Gallery Management
@stop

@section('styles')
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .gallery-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .gallery-item-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .gallery-item-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .gallery-item:hover .gallery-item-overlay {
        opacity: 1;
    }
    .gallery-item-info {
        padding: 15px;
        background: white;
    }
    .gallery-item-badges {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 5px;
        z-index: 1;
    }
</style>
@stop

@section('content')
    <div class="row small-spacing">
        <div class="col-xs-12">
            <div class="box-content">
                <div class="clearfix bg-lighter">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">Gallery Management</h3>
                        <div class="btn-group">
                            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                                <i class="ri-add-box-line"></i> Add Single Item
                            </a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
                                <i class="ri-upload-2-line"></i> Bulk Upload
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('admin.gallery.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image</option>
                                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
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
                                    <option value="">All Items</option>
                                    <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                                    <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Regular</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>

                <!-- Gallery Grid -->
                <div class="gallery-grid">
                    @forelse ($galleries as $key => $item)
                        <div class="gallery-item" id="row_{{ $key }}">
                            <!-- Badges -->
                            <div class="gallery-item-badges">
                                @if($item->is_featured)
                                    <span class="badge bg-warning">
                                        <i class="ri-star-fill"></i>
                                    </span>
                                @endif
                                @if(!$item->is_active)
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>

                            <!-- Image -->
                            <div style="position: relative;">
                                @if($item->thumbnail_url)
                                    <img src="{{ asset('storage/' . $item->thumbnail_url) }}" alt="{{ $item->alt_text ?? $item->title }}" class="gallery-item-image">
                                @elseif($item->image_url)
                                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->alt_text ?? $item->title }}" class="gallery-item-image">
                                @else
                                    <div class="gallery-item-image" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                        <i class="ri-image-line" style="font-size: 48px;"></i>
                                    </div>
                                @endif

                                <!-- Overlay Actions -->
                                <div class="gallery-item-overlay">
                                    <div class="btn-group-vertical">
                                        <a href="{{ route('admin.gallery.show', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="ri-eye-line"></i> View
                                        </a>
                                        <a href="{{ route('admin.gallery.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                            <i class="ri-edit-line"></i> Edit
                                        </a>
                                        <button type="button"
                                            onclick="toggleStatus('{{ route('admin.gallery.toggle-status', $item->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $item->is_active ? 'true' : 'false' }})"
                                            class="btn btn-{{ $item->is_active ? 'warning' : 'success' }} btn-sm">
                                            <i class="ri-{{ $item->is_active ? 'pause' : 'play' }}-line"></i> {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                        <button type="button"
                                            onclick="toggleFeatured('{{ route('admin.gallery.toggle-featured', $item->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $item->is_featured ? 'true' : 'false' }})"
                                            class="btn btn-{{ $item->is_featured ? 'secondary' : 'warning' }} btn-sm">
                                            <i class="ri-star-{{ $item->is_featured ? 'fill' : 'line' }}"></i> {{ $item->is_featured ? 'Unfeature' : 'Feature' }}
                                        </button>
                                        <button type="button"
                                            onclick="confirmDelete('{{ route('admin.gallery.destroy', $item->id) }}', {{ $key }}, '{{ csrf_token() }}')"
                                            class="btn btn-danger btn-sm">
                                            <i class="ri-delete-bin-line"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="gallery-item-info">
                                <h6 class="mb-1">{{ $item->title }}</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-info">{{ $item->category }}</span>
                                    <span class="badge bg-secondary">{{ ucfirst($item->type) }}</span>
                                </div>
                                @if($item->description)
                                    <small class="text-muted d-block">{{ Str::limit($item->description, 50) }}</small>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="ri-image-line" style="font-size: 64px; color: #dee2e6;"></i>
                            <p class="text-muted mt-3">No gallery items found</p>
                            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                                <i class="ri-add-line"></i> Add First Item
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Upload Modal -->
    <div class="modal fade" id="bulkUploadModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.gallery.bulk-upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Bulk Upload Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulk_category" class="form-label">Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bulk_category" name="category" required list="categoryList">
                            <datalist id="categoryList">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="bulk_type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="bulk_type" name="type" required>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bulk_images" class="form-label">Images <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="bulk_images" name="images[]" multiple required accept="image/*">
                            <small class="text-muted">Select multiple images (max 5MB each)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-upload-2-line"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>

    <script>
        // Toggle featured function
        function toggleFeatured(url, key, token, currentStatus) {
            const action = currentStatus === 'true' ? 'unfeature' : 'feature';
            
            $.ajax({
                type: "POST",
                url: url,
                data: { '_token': token },
                success: function (data) {
                    if (data.success) {
                        location.reload();
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function (xhr) {
                    toastr.error('Failed to update featured status');
                }
            });
        }
    </script>
@endsection

