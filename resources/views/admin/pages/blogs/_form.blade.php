<div class="card-body">
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @if ($method === 'PUT')
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="title" class="required">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                value="{{ old('title', $blog->title ?? '') }}" required>
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="blog_category_id" class="required">Category</label>
            <select id="blog_category_id" name="blog_category_id"
                class="form-control @error('blog_category_id') is-invalid @enderror" required>
                <option value="">Select Category</option>
                @foreach ($categories as $value => $name)
                    <option value="{{ $value }}"
                        {{ (isset($blog) && $blog->blog_category_id == $value) || old('blog_category_id') == $value ? 'selected' : '' }}>
                        {{ $name }}</option>
                @endforeach
            </select>
            @error('blog_category_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tags" class="required">Tags</label>
            <select id="tag" name="tags[]" class="select2 form-control select2-multiple" data-toggle="select2"
                multiple="multiple" data-placeholder="Choose Tags">
                class="form-control select2-multiple @error('tags')
is-invalid
@enderror" required>
                @foreach ($tags as $value => $name)
                    <option value="{{ $value }}" @selected((isset($blog) && in_array($value, $blog->tags->pluck('id')->toArray())) || in_array($value, old('tags', [])))>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="content" class="required">Content</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="50">{{ old('content', $blog->content ?? '') }}</textarea>
            @error('content')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="meta_title">Meta Title</label>
            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                name="meta_title" value="{{ old('meta_title', $blog->meta_title ?? '') }}">
            @error('meta_title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="meta_description">Meta Description</label>
            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                name="meta_description" rows="3">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
            @error('meta_description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="meta_keywords">Meta Keywords</label>
            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords"
                name="meta_keywords" value="{{ old('meta_keywords', $blog->meta_keywords ?? '') }}">
            @error('meta_keywords')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="featured_image" class="form-label">Featured Image</label>
            <input type="file" accept="image/*"
                class="form-control file-preview @error('featured_image') is-invalid @enderror" id="featured_image"
                name="featured_image">
            <div id="" class="form-text text-danger">{{ Str::img_size('blogs') }}</div>
            @error('featured_image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label class=""></label>
            <div class="col-sm-auto">
                <div id="post-img">
                    @if (isset($blog) && $blog->featured_image)
                        <img src="{{ Str::storage_path($blog->featured_image) }}" height="200px" width="auto">
                    @else
                        <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="status" class="required">Status</label>
            <select id="sts" name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">Select Status</option>
                @foreach ($statusOptions as $name => $value)
                    <option value="{{ $value }}"
                        {{ (isset($blog) && $blog->status == $value) || old('status') == $value ? 'selected' : '' }}>
                        {{ $name }}</option>
                @endforeach
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
        </div>
    </form>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/filepreview.js') }}"></script>
    <script>
        new showFilePreview([{
            inputSelector: "form .file-preview",
            imgContainer: "#post-img"
        }]);
    </script>
@endpush
