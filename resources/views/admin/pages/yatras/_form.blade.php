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
                        <label for="title" class="form-label">Yatra Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $yatra->title ?? '') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description', $yatra->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Location Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                               id="city" name="city" value="{{ old('city', $yatra->city ?? '') }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="month" class="form-label">Month</label>
                        <select class="form-select @error('month') is-invalid @enderror" id="month" name="month">
                            <option value="">Select Month</option>
                            @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                <option value="{{ $month }}" {{ old('month', $yatra->month ?? '') == $month ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                        @error('month')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="collaborating_center" class="form-label">Collaborating Center</label>
                        <input type="text" class="form-control @error('collaborating_center') is-invalid @enderror" 
                               id="collaborating_center" name="collaborating_center" value="{{ old('collaborating_center', $yatra->collaborating_center ?? '') }}">
                        <small class="text-muted">e.g., ISKCON Temple Name</small>
                        @error('collaborating_center')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Details (JSON) -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Additional Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Details</label>
                        <small class="text-muted d-block mb-2">Add additional information like accommodation, transportation, contact info, etc.</small>
                        
                        <div id="details-container">
                            @if(isset($yatra) && is_array($yatra->details))
                                @foreach($yatra->details as $key => $value)
                                    <div class="row mb-2 detail-item">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="details[{{ $loop->index }}][key]" placeholder="Key (e.g., Accommodation)" value="{{ $key }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="details[{{ $loop->index }}][value]" placeholder="Value" value="{{ $value }}">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeDetail(this)">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2 detail-item">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="details[0][key]" placeholder="Key (e.g., Accommodation)">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="details[0][value]" placeholder="Value">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeDetail(this)">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addDetail()">
                            <i class="ri-add-line"></i> Add Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Yatra Image -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Yatra Image</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    @if(isset($yatra) && $yatra->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $yatra->image) }}" 
                                 alt="{{ $yatra->title }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 200px; width: 100%; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    <small class="text-muted">Yatra image (max 2MB)</small>
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
                <h4 class="card-title">Yatra Timeline</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                           id="start_date" name="start_date" value="{{ old('start_date', isset($yatra) ? $yatra->start_date->format('Y-m-d') : '') }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                           id="end_date" name="end_date" value="{{ old('end_date', isset($yatra) ? $yatra->end_date->format('Y-m-d') : '') }}" required>
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
                    <label for="status" class="form-label">Yatra Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="upcoming" {{ old('status', $yatra->status ?? '') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ old('status', $yatra->status ?? '') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status', $yatra->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $yatra->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                           id="sort_order" name="sort_order" value="{{ old('sort_order', $yatra->sort_order ?? '') }}" min="0">
                    <small class="text-muted">Lower numbers appear first</small>
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                               {{ old('is_featured', $yatra->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured Yatra
                        </label>
                    </div>
                    <small class="text-muted">Featured yatras appear in special sections</small>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> {{ isset($yatra) ? 'Update Yatra' : 'Create Yatra' }}
                    </button>
                    <a href="{{ route('admin.yatras.index') }}" class="btn btn-secondary">
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

    // Details management
    let detailIndex = {{ isset($yatra) && is_array($yatra->details) ? count($yatra->details) : 1 }};

    function addDetail() {
        const container = document.getElementById('details-container');
        const detailItem = document.createElement('div');
        detailItem.className = 'row mb-2 detail-item';
        detailItem.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" name="details[${detailIndex}][key]" placeholder="Key (e.g., Accommodation)">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="details[${detailIndex}][value]" placeholder="Value">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeDetail(this)">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        `;
        container.appendChild(detailItem);
        detailIndex++;
    }

    function removeDetail(button) {
        button.closest('.detail-item').remove();
    }
</script>
@endpush

