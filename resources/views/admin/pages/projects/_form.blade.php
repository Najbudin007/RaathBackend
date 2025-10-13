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
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Project Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $project->title ?? '') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $project->slug ?? '') }}">
                        <small class="text-muted">Leave empty to auto-generate from title</small>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" name="short_description" rows="2">{{ old('short_description', $project->short_description ?? '') }}</textarea>
                        <small class="text-muted">Brief summary (max 500 characters)</small>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Full Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="6" required>{{ old('description', $project->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="vision" class="form-label">Vision & Goals</label>
                        <textarea class="form-control @error('vision') is-invalid @enderror" 
                                  id="vision" name="vision" rows="4">{{ old('vision', $project->vision ?? '') }}</textarea>
                        @error('vision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="technical_specs" class="form-label">Technical Specifications</label>
                        <textarea class="form-control @error('technical_specs') is-invalid @enderror" 
                                  id="technical_specs" name="technical_specs" rows="4">{{ old('technical_specs', $project->technical_specs ?? '') }}</textarea>
                        @error('technical_specs')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Financial Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="target_amount" class="form-label">Target Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" class="form-control @error('target_amount') is-invalid @enderror" 
                                   id="target_amount" name="target_amount" value="{{ old('target_amount', $project->target_amount ?? '') }}" required>
                        </div>
                        @error('target_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="collected_amount" class="form-label">Collected Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" class="form-control @error('collected_amount') is-invalid @enderror" 
                                   id="collected_amount" name="collected_amount" value="{{ old('collected_amount', $project->collected_amount ?? '0') }}">
                        </div>
                        @error('collected_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="budget" class="form-label">Total Budget</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" class="form-control @error('budget') is-invalid @enderror" 
                                   id="budget" name="budget" value="{{ old('budget', $project->budget ?? '') }}">
                        </div>
                        @error('budget')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery & Documents -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Gallery & Documents</h4>
            </div>
            <div class="card-body">
                <!-- Gallery Images -->
                <div class="mb-3">
                    <label for="images" class="form-label">Gallery Images</label>
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                           id="images" name="images[]" accept="image/*" multiple>
                    <small class="text-muted">Select multiple images for project gallery (max 2MB each)</small>
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Current Gallery Images (for edit) -->
                @if(isset($project) && $project->images)
                    <div class="row mb-3" id="current-gallery">
                        <h6>Current Gallery:</h6>
                        @foreach($project->images as $index => $image)
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

                <!-- Design Documents -->
                <div class="mb-3">
                    <label for="design_docs" class="form-label">Design Documents</label>
                    <input type="file" class="form-control @error('design_docs.*') is-invalid @enderror" 
                           id="design_docs" name="design_docs[]" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" multiple>
                    <small class="text-muted">Upload project documents (PDF, DOC, XLS, PPT - max 5MB each)</small>
                    @error('design_docs.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Current Documents (for edit) -->
                @if(isset($project) && $project->design_docs)
                    <div class="mb-3" id="current-docs">
                        <h6>Current Documents:</h6>
                        <div class="list-group">
                            @foreach($project->design_docs as $index => $doc)
                                <div class="list-group-item d-flex justify-content-between align-items-center" id="doc-{{ $index }}">
                                    <span>
                                        <i class="ri-file-line"></i> {{ basename($doc) }}
                                    </span>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="removeDocument('{{ $doc }}', 'doc-{{ $index }}')">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Main Image -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Main Project Image</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    @if(isset($project) && $project->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $project->image) }}" 
                                 alt="{{ $project->title }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 200px; width: 100%; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    <small class="text-muted">Main project image (max 2MB)</small>
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

        <!-- Timeline -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Project Timeline</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                           id="start_date" name="start_date" value="{{ old('start_date', isset($project) ? $project->start_date->format('Y-m-d') : '') }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                           id="end_date" name="end_date" value="{{ old('end_date', isset($project) ? $project->end_date->format('Y-m-d') : '') }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                    <label for="status" class="form-label">Project Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="planning" {{ old('status', $project->status ?? '') == 'planning' ? 'selected' : '' }}>Planning</option>
                        <option value="active" {{ old('status', $project->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="on-hold" {{ old('status', $project->status ?? '') == 'on-hold' ? 'selected' : '' }}>On Hold</option>
                        <option value="completed" {{ old('status', $project->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $project->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                               {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured Project
                        </label>
                    </div>
                    <small class="text-muted">Featured projects appear in special sections</small>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> {{ isset($project) ? 'Update Project' : 'Create Project' }}
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                        <i class="ri-close-line"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const slugField = document.getElementById('slug');
        if (!slugField.value || slugField.value === this.dataset.oldValue) {
            slugField.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
        }
        this.dataset.oldValue = slugField.value;
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

    // Remove gallery image
    function removeImage(imagePath, elementId) {
        if (confirm('Are you sure you want to remove this image?')) {
            fetch(`{{ route('admin.projects.remove-image', isset($project) ? $project->id : 0) }}`, {
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

    // Remove document
    function removeDocument(docPath, elementId) {
        if (confirm('Are you sure you want to remove this document?')) {
            fetch(`{{ route('admin.projects.remove-document', isset($project) ? $project->id : 0) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    doc_path: docPath
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
                toastr.error('Failed to remove document');
            });
        }
    }
</script>
@endpush

