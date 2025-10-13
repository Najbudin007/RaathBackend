<div class="card border-primary border">
    <h4 class="card-header bg-lighttext-primary"> {{ $method === 'PUT' ? 'Edit' : 'Create New' }} </h4>
    <div class="card-body">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if ($method === 'PUT')
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="title" class="required">Title</label>
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                    name="title" required value="{{ old('title', $portfolio->title ?? '') }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            {{-- <div class="mb-3">
                <label for="slug" class="">Slug</label>
                <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                    name="slug" value="{{ old('slug', $portfolio->slug ?? '') }}">
                @error('slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}
            <div class="mb-3">
                <label for="category_id" class="required">Category</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $name => $value)
                        <option value="{{ $value }}"
                            {{ (isset($portfolio) && $portfolio->category_id == $value) || old('category_id') == $value ? 'selected' : '' }}>
                            {{ $name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="required">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $portfolio->description ?? '') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="case_study" class="">Case Study</label>
                <textarea id="case_study" name="case_study" class="form-control  @error('case_study') is-invalid @enderror">{{ old('case_study', $portfolio->case_study ?? '') }}</textarea>
                @error('case_study')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 row">
                <label for="feature_image" class="">Feature Image</label>
                <input id="feature_image" type="file" accept="image/*"
                    class="form-control file-preview @error('feature_image') is-invalid @enderror" name="feature_image">
                <div id="" class="form-text text-danger">{{ Str::img_size('portfolios') }}</div>

                @error('feature_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label class=""></label>
                <div class="col-sm-auto">
                    <div id="post-img">
                        @if (isset($portfolio) && $portfolio->feature_image)
                            <img src="{{ Str::storage_path($portfolio->feature_image) }}" height="200px"
                                width="auto">
                        @else
                            <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                        @endif
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="required">Status</label>
                <select id="sts" name="status" class="form-select" required>
                    <option value="">Select Status</option>
                    @foreach ($statusOptions as $name => $value)
                        <option value="{{ $value }}"
                            {{ (isset($portfolio) && $portfolio->status == $value) || old('status') == $value ? 'selected' : '' }}>
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
                <button type="submit" class="btn btn-primary">
                    {{ $method === 'PUT' ? 'Update' : 'Submit' }}
                </button>
            </div>
        </form>
    </div>
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
