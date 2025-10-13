<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><h4>Donor Information</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>User (if registered)</label>
                        <select class="form-select" name="user_id">
                            <option value="">Guest/Anonymous</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $donation->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Project</label>
                        <select class="form-select" name="project_id">
                            <option value="">General Donation</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', $donation->project_id ?? '') == $project->id ? 'selected' : '' }}>
                                    {{ $project->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Donor Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('donor_name') is-invalid @enderror" name="donor_name" value="{{ old('donor_name', $donation->donor_name ?? '') }}" required>
                        @error('donor_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('donor_email') is-invalid @enderror" name="donor_email" value="{{ old('donor_email', $donation->donor_email ?? '') }}" required>
                        @error('donor_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="donor_phone" value="{{ old('donor_phone', $donation->donor_phone ?? '') }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Message/Note</label>
                        <textarea class="form-control" name="message" rows="3">{{ old('message', $donation->message ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h4>Payment Information</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount', $donation->amount ?? '') }}" required>
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Payment Method <span class="text-danger">*</span></label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method" required>
                            <option value="">Select Method</option>
                            <option value="esewa" {{ old('payment_method', $donation->payment_method ?? '') == 'esewa' ? 'selected' : '' }}>eSewa</option>
                            <option value="khalti" {{ old('payment_method', $donation->payment_method ?? '') == 'khalti' ? 'selected' : '' }}>Khalti</option>
                            <option value="cash" {{ old('payment_method', $donation->payment_method ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank" {{ old('payment_method', $donation->payment_method ?? '') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="cheque" {{ old('payment_method', $donation->payment_method ?? '') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        </select>
                        @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Transaction ID</label>
                        <input type="text" class="form-control" name="transaction_id" value="{{ old('transaction_id', $donation->transaction_id ?? '') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><h4>Status</h4></div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Donation Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="pending" {{ old('status', $donation->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status', $donation->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ old('status', $donation->status ?? '') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ old('status', $donation->status ?? '') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_anonymous" {{ old('is_anonymous', $donation->is_anonymous ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label">Anonymous Donation</label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> {{ isset($donation) ? 'Update' : 'Create' }}
                    </button>
                    <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

