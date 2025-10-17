<div class="row">
    <!-- Basic Information -->
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Basic Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $product->slug ?? '') }}">
                        <small class="text-muted">Leave empty to auto-generate from name</small>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? '') }}" min="0">
                        <small class="text-muted">Lower numbers appear first</small>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Pricing & Stock</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="price" class="form-label">Regular Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $product->price ?? '') }}" required>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="sale_price" class="form-label">Sale Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" class="form-control @error('sale_price') is-invalid @enderror" 
                                   id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price ?? '') }}">
                        </div>
                        <small class="text-muted">Leave empty for no sale. Must be less than regular price.</small>
                        @error('sale_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="stock_quantity" class="form-label">Stock Quantity</label>
                        <input type="number" min="0" class="form-control @error('stock_quantity') is-invalid @enderror" 
                               id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? '') }}">
                        <small class="text-muted">Leave empty for unlimited stock</small>
                        @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Images -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Gallery Images</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="images" class="form-label">Additional Images</label>
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                           id="images" name="images[]" accept="image/*" multiple>
                    <small class="text-muted">Select multiple images for product gallery (max 5MB each)</small>
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Current Gallery Images (for edit) -->
                @if(isset($product) && $product->images)
                    <div class="row" id="current-gallery">
                        <h6>Current Gallery:</h6>
                        @foreach($product->images as $index => $image)
                            <div class="col-md-3 mb-2" id="gallery-image-{{ $index }}">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                                            onclick="removeImage('{{ $image }}', 'gallery-image-{{ $index }}')" style="margin: 2px;">
                                        <i class="ri-close-line"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- New Gallery Preview -->
                <div id="galleryPreview" class="row mt-3" style="display: none;">
                    <h6>New Images:</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Main Image Card -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Main Product Image</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    @if(isset($product) && $product->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 200px; width: 100%; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    <small class="text-muted">Main product image (max 5MB)</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Preview -->
                <div id="imagePreview" style="display: none;">
                    <img id="preview" src="" alt="Preview" class="img-fluid rounded mt-2" style="max-height: 200px; width: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <!-- Status & Options -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Status & Options</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active Product
                        </label>
                    </div>
                    <small class="text-muted">Inactive products won't be visible to customers</small>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                               {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured Product
                        </label>
                    </div>
                    <small class="text-muted">Featured products appear in special sections</small>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> {{ isset($product) ? 'Update Product' : 'Create Product' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="ri-close-line"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Enhanced form submission debugging
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('Form is being submitted...');
                
                // Debug: Log all form data
                const formData = new FormData(form);
                console.log('Form Data:');
                for (let [key, value] of formData.entries()) {
                    if (value instanceof File) {
                        console.log(`${key}: File(${value.name}, ${value.size} bytes, ${value.type})`);
                    } else {
                        console.log(`${key}: ${value}`);
                    }
                }
                
                // Check if required fields are filled
                const requiredFields = ['category_id', 'name', 'price'];
                const missingFields = [];
                
                requiredFields.forEach(field => {
                    const element = form.querySelector(`[name="${field}"]`);
                    if (!element || !element.value.trim()) {
                        missingFields.push(field);
                    }
                });
                
                if (missingFields.length > 0) {
                    console.error('Missing required fields:', missingFields);
                    alert('Please fill in all required fields: ' + missingFields.join(', '));
                    e.preventDefault();
                    return false;
                }
                
                // Check if category is selected
                const categorySelect = form.querySelector('[name="category_id"]');
                if (!categorySelect.value) {
                    console.error('No category selected');
                    alert('Please select a category');
                    e.preventDefault();
                    return false;
                }
                
                console.log('Form validation passed, submitting...');
            });
        }
    });

    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const slugField = document.getElementById('slug');
        if (!slugField.value) {
            slugField.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
        }
    });

    // Main image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Gallery images preview
    document.getElementById('images').addEventListener('change', function(e) {
        const files = e.target.files;
        const previewContainer = document.getElementById('galleryPreview');
        previewContainer.innerHTML = '<h6>New Images:</h6>';
        
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-6 mb-2';
                col.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                `;
                previewContainer.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
        
        if (files.length > 0) {
            previewContainer.style.display = 'block';
        }
    });

    // Remove gallery image
    function removeImage(imagePath, elementId) {
        if (confirm('Are you sure you want to remove this image?')) {
            // Send AJAX request to remove image
            fetch(`{{ route('admin.products.remove-image', isset($product) ? $product->id : 0) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    image_path: imagePath
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(elementId).remove();
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('Failed to remove image');
            });
        }
    }
</script>
@endpush

