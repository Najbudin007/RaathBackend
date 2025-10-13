<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><h4>Subscriber Information</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $subscriber->name ?? '') }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $subscriber->email ?? '') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>City</label>
                        <input type="text" class="form-control" name="city" value="{{ old('city', $subscriber->city ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Membership Status</label>
                        <input type="text" class="form-control" name="membership_status" value="{{ old('membership_status', $subscriber->membership_status ?? '') }}">
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
                    <label>Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="active" {{ old('status', $subscriber->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $subscriber->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="unsubscribed" {{ old('status', $subscriber->status ?? '') == 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="email_opt_in" {{ old('email_opt_in', $subscriber->email_opt_in ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label">Email Opt-in</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="whatsapp_opt_in" {{ old('whatsapp_opt_in', $subscriber->whatsapp_opt_in ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label">WhatsApp Opt-in</label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> {{ isset($subscriber) ? 'Update' : 'Create' }}
                    </button>
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

