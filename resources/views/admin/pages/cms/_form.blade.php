<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><h4>Page Content</h4></div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $cmsPage->title ?? '') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label>Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $cmsPage->slug ?? '') }}">
                    <small class="text-muted">Leave empty to auto-generate from title</small>
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label>Content <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="15" required>{{ old('content', $cmsPage->content ?? '') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><h4>SEO Settings</h4></div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $cmsPage->meta_title ?? '') }}">
                </div>
                <div class="mb-3">
                    <label>Meta Description</label>
                    <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description', $cmsPage->meta_description ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Meta Keywords</label>
                    <input type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords', $cmsPage->meta_keywords ?? '') }}">
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h4>Status</h4></div>
            <div class="card-body">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" {{ old('is_active', $cmsPage->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> {{ isset($cmsPage) ? 'Update' : 'Create' }}
                    </button>
                    <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('title').addEventListener('input', function() {
    const slugField = document.getElementById('slug');
    if (!slugField.value) {
        slugField.value = this.value.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }
});
</script>
@endpush

