<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label>Project <span class="text-danger">*</span></label>
                    <select class="form-select" name="project_id" required>
                        @foreach($projects as $proj)
                            <option value="{{ $proj->id }}" {{ old('project_id', $sponsorshipTier->project_id ?? '') == $proj->id ? 'selected' : '' }}>{{ $proj->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Tier Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $sponsorshipTier->name ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label>Amount <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" name="amount" value="{{ old('amount', $sponsorshipTier->amount ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description', $sponsorshipTier->description ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Inscription Type</label>
                    <input type="text" class="form-control" name="inscription_type" value="{{ old('inscription_type', $sponsorshipTier->inscription_type ?? '') }}">
                </div>
                <div class="mb-3">
                    <label>Benefits</label>
                    <div id="benefits">
                        @if(isset($sponsorshipTier) && $sponsorshipTier->benefits)
                            @foreach($sponsorshipTier->benefits as $b)
                                <div class="input-group mb-2"><input type="text" class="form-control" name="benefits[]" value="{{ $b }}"><button type="button" class="btn btn-danger" onclick="this.parentElement.remove()"><i class="ri-delete-bin-line"></i></button></div>
                            @endforeach
                        @else
                            <div class="input-group mb-2"><input type="text" class="form-control" name="benefits[]"><button type="button" class="btn btn-danger" onclick="this.parentElement.remove()"><i class="ri-delete-bin-line"></i></button></div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('benefits').insertAdjacentHTML('beforeend', '<div class=\'input-group mb-2\'><input type=\'text\' class=\'form-control\' name=\'benefits[]\'><button type=\'button\' class=\'btn btn-danger\' onclick=\'this.parentElement.remove()\'><i class=\'ri-delete-bin-line\'></i></button></div>')">Add</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label>Sort Order</label>
                    <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $sponsorshipTier->sort_order ?? '') }}">
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" {{ old('is_active', $sponsorshipTier->is_active ?? true) ? 'checked' : '' }}>
                    <label>Active</label>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary w-100">{{ isset($sponsorshipTier) ? 'Update' : 'Create' }}</button>
                <a href="{{ route('admin.sponsorship-tiers.index') }}" class="btn btn-secondary w-100 mt-2">Cancel</a>
            </div>
        </div>
    </div>
</div>

