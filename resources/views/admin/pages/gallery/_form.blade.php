<div class="row">
    <!-- Main Content -->
    <div class="col-md-8">
        <!-- Basic Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Basic Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $gallery->title ?? '') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $gallery->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('category') is-invalid @enderror" 
                               id="category" name="category" value="{{ old('category', $gallery->category ?? '') }}" required list="existingCategories">
                        <datalist id="existingCategories">
                            @if(isset($categories))
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                            @endif
                        </datalist>
                        <small class="text-muted">e.g., Events, Festivals, Deities, Temple</small>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="image" {{ old('type', $gallery->type ?? '') == 'image' ? 'selected' : '' }}>Image</option>
                            <option value="video" {{ old('type', $gallery->type ?? '') == 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="alt_text" class="form-label">Alt Text (SEO)</label>
                        <input type="text" class="form-control @error('alt_text') is-invalid @enderror" 
                               id="alt_text" name="alt_text" value="{{ old('alt_text', $gallery->alt_text ?? '') }}">
                        <small class="text-muted">Alternative text for SEO and accessibility</small>
                        @error('alt_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Metadata (JSON) -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Additional Metadata</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Metadata</label>
                        <small class="text-muted d-block mb-2">Add additional information like photographer, location, event date, etc.</small>
                        
                        <div id="metadata-container">
                            @if(isset($gallery) && is_array($gallery->metadata))
                                @foreach($gallery->metadata as $key => $value)
                                    <div class="row mb-2 metadata-item">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="metadata[{{ $loop->index }}][key]" placeholder="Key (e.g., Photographer)" value="{{ $key }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="metadata[{{ $loop->index }}][value]" placeholder="Value" value="{{ $value }}">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeMetadata(this)">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2 metadata-item">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="metadata[0][key]" placeholder="Key (e.g., Photographer)">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="metadata[0][value]" placeholder="Value">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeMetadata(this)">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addMetadata()">
                            <i class="ri-add-line"></i> Add Metadata
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Gallery Image -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Gallery Image @if(!isset($gallery))<span class="text-danger">*</span>@endif</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    @if(isset($gallery) && $gallery->image_url)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $gallery->image_url) }}" 
                                 alt="{{ $gallery->alt_text ?? $gallery->title }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 250px; width: 100%; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image_url') is-invalid @enderror" 
                           id="image_url" name="image_url" accept="image/*" @if(!isset($gallery)) required @endif>
                    <small class="text-muted">Max size: 5MB. Thumbnail will be auto-generated.</small>
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Preview -->
                <div id="imagePreview" style="display: none;">
                    <img id="preview" src="" alt="Preview" class="img-fluid rounded mt-2" style="max-height: 250px; width: 100%; object-fit: cover;">
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
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                           id="sort_order" name="sort_order" value="{{ old('sort_order', $gallery->sort_order ?? '') }}" min="0">
                    <small class="text-muted">Lower numbers appear first</small>
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                               {{ old('is_active', $gallery->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    <small class="text-muted">Inactive items won't be visible to visitors</small>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                               {{ old('is_featured', $gallery->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured
                        </label>
                    </div>
                    <small class="text-muted">Featured items appear in special sections</small>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> {{ isset($gallery) ? 'Update Gallery Item' : 'Create Gallery Item' }}
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                        <i class="ri-close-line"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview
    document.getElementById('image_url').addEventListener('change', function(e) {
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

    // Metadata management
    let metadataIndex = {{ isset($gallery) && is_array($gallery->metadata) ? count($gallery->metadata) : 1 }};

    function addMetadata() {
        const container = document.getElementById('metadata-container');
        const metadataItem = document.createElement('div');
        metadataItem.className = 'row mb-2 metadata-item';
        metadataItem.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" name="metadata[${metadataIndex}][key]" placeholder="Key (e.g., Photographer)">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="metadata[${metadataIndex}][value]" placeholder="Value">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeMetadata(this)">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        `;
        container.appendChild(metadataItem);
        metadataIndex++;
    }

    function removeMetadata(button) {
        button.closest('.metadata-item').remove();
    }
</script>
@endpush

