<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <label>Project</label>
            <select class="form-select" name="project_id">
                <option value="">General Document</option>
                @foreach($projects as $proj)
                    <option value="{{ $proj->id }}" {{ old('project_id', $document->project_id ?? '') == $proj->id ? 'selected' : '' }}>{{ $proj->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $document->title ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Type <span class="text-danger">*</span></label>
            <select class="form-select" name="type" required>
                <option value="pdf" {{ old('type', $document->type ?? '') == 'pdf' ? 'selected' : '' }}>PDF</option>
                <option value="image" {{ old('type', $document->type ?? '') == 'image' ? 'selected' : '' }}>Image</option>
                <option value="video" {{ old('type', $document->type ?? '') == 'video' ? 'selected' : '' }}>Video</option>
                <option value="other" {{ old('type', $document->type ?? '') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label>File @if(!isset($document))<span class="text-danger">*</span>@endif</label>
            <input type="file" class="form-control" name="file_url" @if(!isset($document)) required @endif>
            <small>Max 10MB</small>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="3">{{ old('description', $document->description ?? '') }}</textarea>
        </div>
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="is_public" {{ old('is_public', $document->is_public ?? true) ? 'checked' : '' }}>
            <label>Public Access</label>
        </div>
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" {{ old('is_active', $document->is_active ?? true) ? 'checked' : '' }}>
            <label>Active</label>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($document) ? 'Update' : 'Upload' }}</button>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

