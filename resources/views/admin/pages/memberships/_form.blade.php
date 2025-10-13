<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><h4>Basic Information</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $membership->name ?? '') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tier Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tier_name') is-invalid @enderror" name="tier_name" value="{{ old('tier_name', $membership->tier_name ?? '') }}" required>
                        @error('tier_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $membership->price ?? '') }}" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Duration (Days) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('duration_days') is-invalid @enderror" name="duration_days" value="{{ old('duration_days', $membership->duration_days ?? '') }}" required>
                        @error('duration_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Color Theme</label>
                        <input type="color" class="form-control @error('color_theme') is-invalid @enderror" name="color_theme" value="{{ old('color_theme', $membership->color_theme ?? '#007bff') }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description', $membership->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h4>Benefits</h4></div>
            <div class="card-body">
                <div id="benefits-container">
                    @if(isset($membership) && $membership->benefits)
                        @foreach($membership->benefits as $index => $benefit)
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="benefits[]" value="{{ $benefit }}">
                                <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()"><i class="ri-delete-bin-line"></i></button>
                            </div>
                        @endforeach
                    @else
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="benefits[]" placeholder="Benefit">
                            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()"><i class="ri-delete-bin-line"></i></button>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addBenefit()"><i class="ri-add-line"></i> Add Benefit</button>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h4>Additional Details</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Seating Priority</label>
                        <input type="text" class="form-control" name="seating_priority" value="{{ old('seating_priority', $membership->seating_priority ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Annual Kit Type</label>
                        <input type="text" class="form-control" name="annual_kit_type" value="{{ old('annual_kit_type', $membership->annual_kit_type ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Newsletter Frequency</label>
                        <input type="text" class="form-control" name="newsletter_frequency" value="{{ old('newsletter_frequency', $membership->newsletter_frequency ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Events Access</label>
                        <input type="text" class="form-control" name="events_access" value="{{ old('events_access', $membership->events_access ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Certificate Type</label>
                        <input type="text" class="form-control" name="certificate_type" value="{{ old('certificate_type', $membership->certificate_type ?? '') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><h4>Settings</h4></div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Sort Order</label>
                    <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $membership->sort_order ?? '') }}">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_volunteer_based" {{ old('is_volunteer_based', $membership->is_volunteer_based ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label">Volunteer Based</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" {{ old('is_active', $membership->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> {{ isset($membership) ? 'Update' : 'Create' }}
                    </button>
                    <a href="{{ route('admin.memberships.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function addBenefit() {
    const container = document.getElementById('benefits-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="benefits[]" placeholder="Benefit">
        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()"><i class="ri-delete-bin-line"></i></button>
    `;
    container.appendChild(div);
}
</script>
@endpush

