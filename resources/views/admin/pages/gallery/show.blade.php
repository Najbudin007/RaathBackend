@extends('admin.layouts.main')
@section('title')
    Gallery Item - {{ $gallery->title }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <div class="btn-group">
                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line"></i> Edit
                        </a>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back to Gallery
                        </a>
                    </div>
                </div>
                <h4 class="page-title">Gallery Item Details</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Image Display -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if($gallery->image_url)
                        <img src="{{ asset('storage/' . $gallery->image_url) }}" 
                             alt="{{ $gallery->alt_text ?? $gallery->title }}" 
                             class="img-fluid rounded"
                             style="width: 100%; max-height: 600px; object-fit: contain; background: #f8f9fa;">
                    @else
                        <div style="height: 400px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                            <div class="text-center">
                                <i class="ri-image-line" style="font-size: 64px;"></i>
                                <p class="mt-2 mb-0">No Image</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if($gallery->description)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Description</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ $gallery->description }}</p>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            @if($gallery->metadata && count($gallery->metadata) > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Additional Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <tbody>
                                    @foreach($gallery->metadata as $key => $value)
                                        <tr>
                                            <td style="width: 30%;"><strong>{{ ucfirst($key) }}</strong></td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Details Sidebar -->
        <div class="col-md-4">
            <!-- Item Info -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Item Information</h4>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">{{ $gallery->title }}</h5>
                    
                    <div class="mb-3">
                        <span class="badge bg-info fs-6">{{ $gallery->category }}</span>
                        <span class="badge bg-secondary fs-6">{{ ucfirst($gallery->type) }}</span>
                        @if($gallery->is_featured)
                            <span class="badge bg-warning fs-6">Featured</span>
                        @endif
                        @if($gallery->is_active)
                            <span class="badge bg-success fs-6">Active</span>
                        @else
                            <span class="badge bg-secondary fs-6">Inactive</span>
                        @endif
                    </div>

                    <hr>

                    <dl class="row mb-0">
                        @if($gallery->alt_text)
                            <dt class="col-sm-4">Alt Text:</dt>
                            <dd class="col-sm-8">{{ $gallery->alt_text }}</dd>
                        @endif

                        <dt class="col-sm-4">Sort Order:</dt>
                        <dd class="col-sm-8">{{ $gallery->sort_order ?? 0 }}</dd>

                        <dt class="col-sm-4">Created:</dt>
                        <dd class="col-sm-8">{{ $gallery->created_at->format('M d, Y') }}</dd>

                        <dt class="col-sm-4">Updated:</dt>
                        <dd class="col-sm-8">{{ $gallery->updated_at->format('M d, Y') }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Image URLs -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Image URLs</h4>
                </div>
                <div class="card-body">
                    @if($gallery->image_url)
                        <div class="mb-3">
                            <label class="form-label"><strong>Full Image:</strong></label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" value="{{ asset('storage/' . $gallery->image_url) }}" readonly id="fullImageUrl">
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('fullImageUrl')">
                                    <i class="ri-file-copy-line"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if($gallery->thumbnail_url)
                        <div class="mb-3">
                            <label class="form-label"><strong>Thumbnail:</strong></label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" value="{{ asset('storage/' . $gallery->thumbnail_url) }}" readonly id="thumbnailUrl">
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('thumbnailUrl')">
                                    <i class="ri-file-copy-line"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Thumbnail Preview -->
                        <div class="mt-2">
                            <label class="form-label"><strong>Thumbnail Preview:</strong></label>
                            <img src="{{ asset('storage/' . $gallery->thumbnail_url) }}" 
                                 alt="Thumbnail" 
                                 class="img-fluid rounded border">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button"
                            onclick="toggleStatus('{{ route('admin.gallery.toggle-status', $gallery->id) }}', 0, '{{ csrf_token() }}', {{ $gallery->is_active ? 'true' : 'false' }})"
                            class="btn btn-{{ $gallery->is_active ? 'warning' : 'success' }}">
                            <i class="ri-{{ $gallery->is_active ? 'pause' : 'play' }}-line"></i>
                            {{ $gallery->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                        <button type="button"
                            onclick="toggleFeatured('{{ route('admin.gallery.toggle-featured', $gallery->id) }}', 0, '{{ csrf_token() }}', {{ $gallery->is_featured ? 'true' : 'false' }})"
                            class="btn btn-{{ $gallery->is_featured ? 'secondary' : 'warning' }}">
                            <i class="ri-star-{{ $gallery->is_featured ? 'fill' : 'line' }}"></i>
                            {{ $gallery->is_featured ? 'Unfeature' : 'Feature' }}
                        </button>
                        <button type="button"
                            onclick="confirmDelete('{{ route('admin.gallery.destroy', $gallery->id) }}', 0, '{{ csrf_token() }}')"
                            class="btn btn-danger">
                            <i class="ri-delete-bin-line"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>
    
    <script>
        // Copy to clipboard function
        function copyToClipboard(elementId) {
            const input = document.getElementById(elementId);
            input.select();
            document.execCommand('copy');
            toastr.success('URL copied to clipboard!');
        }

        // Toggle featured function
        function toggleFeatured(url, key, token, currentStatus) {
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
                }
            });
        }

        // Override confirmDelete to redirect after successful deletion
        const originalConfirmDelete = window.confirmDelete;
        window.confirmDelete = function(url, key, token) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: '_token=' + token,
                        success: function (data) {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    data.message || 'Item has been deleted.',
                                    'success'
                                ).then(() => {
                                    window.location.href = "{{ route('admin.gallery.index') }}";
                                });
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', 'Failed to delete item.', 'error');
                        }
                    });
                }
            });
        };
    </script>
@endsection

