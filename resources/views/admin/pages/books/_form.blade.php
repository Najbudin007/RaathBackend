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
                    name="title" required value="{{ old('title', $book->title ?? '') }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="sub_title" class="required">Sub Title</label>
                <input id="sub_title" type="text" class="form-control @error('sub_title') is-invalid @enderror"
                    name="sub_title" required value="{{ old('sub_title', $book->sub_title ?? '') }}">
                @error('sub_title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="status" class="required">Status</label>
                <select id="sts" name="status" class="form-select" required>
                    <option selected>Select Status</option>
                    @foreach ($statusOptions as $name => $value)
                        <option value="{{ $value }}"
                            {{ (isset($book) && $book->status == $value) || old('status') == $value ? 'selected' : '' }}>
                            {{ $name }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 row">
                <label for="icon" class="">Image</label>
                <input id="icon" type="file" accept="image/*"
                    class="form-control file-preview @error('icon') is-invalid @enderror" name="icon">
                <div id="" class="form-text text-danger">{{ Str::img_size('services') }}</div>
                @error('icon')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label class=""></label>
                <div class="col-sm-auto">
                    <div id="post-img">
                        @if (isset($book) && $book->icon)
                            <img src="{{ Str::storage_path($book->icon) }}" height="200px" width="auto">
                        @else
                            <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                        @endif
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="required">Description</label>
                <textarea id="description" name="description" class="form-control required">{{ old('description', $book->description ?? '') }}</textarea>
                @error('description')
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
