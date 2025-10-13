<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <label>Project <span class="text-danger">*</span></label>
            <select class="form-select" name="project_id" required>
                @foreach($projects as $proj)
                    <option value="{{ $proj->id }}" {{ old('project_id', $budgetBreakdown->project_id ?? '') == $proj->id ? 'selected' : '' }}>{{ $proj->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Category <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="category" value="{{ old('category', $budgetBreakdown->category ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control" name="amount" value="{{ old('amount', $budgetBreakdown->amount ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="3">{{ old('description', $budgetBreakdown->description ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($budgetBreakdown) ? 'Update' : 'Create' }}</button>
        <a href="{{ route('admin.budget-breakdowns.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

