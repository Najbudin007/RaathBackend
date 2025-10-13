<div class="card border-primary border">
    <h4 class="card-header bg-lighttext-primary"> {{ $method === 'PUT' ? 'Edit' : 'Create New' }} </h4>
    <div class="card-body">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if ($method === 'PUT')
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="required">Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" required value="{{ old('name', $client->name ?? '') }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="designation" class="required">Designation</label>
                <input id="designation" type="text" class="form-control @error('designation') is-invalid @enderror"
                    name="designation" required value="{{ old('designation', $client->designation ?? '') }}">
                @error('designation')
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
                            {{ (isset($client) && $client->status == $value) || old('status') == $value ? 'selected' : '' }}>
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
                <label for="icon" class="">Icon</label>
                <input id="icon" type="file" accept="image/*"
                    class="form-control file-preview @error('icon') is-invalid @enderror" name="icon">
                    <div id="" class="form-text text-danger">{{ Str::img_size('clients_icon') }}</div>
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
                        @if (isset($client) && $client->icon)
                            <img src="{{ Str::storage_path($client->icon) }}" height="200px" width="auto">
                        @else
                            <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                        @endif
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="logo" class="">Logo</label>
                <input id="logo" type="file" accept="image/*"
                    class="form-control file-preview1 @error('logo') is-invalid @enderror" name="logo">
                    <div id="" class="form-text text-danger">{{ Str::img_size('clients_logo') }}</div>
                @error('logo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label class=""></label>
                <div class="col-sm-auto">
                    <div id="post-logo">
                        @if (isset($client) && $client->logo)
                            <img src="{{ Str::storage_path($client->logo) }}" height="200px" width="auto">
                        @else
                            <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                        @endif
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="">Description</label>
                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                    name="description" value="{{ old('description', $client->description ?? '') }}">
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="rating" class="required">Rating</label>
                <input id="rating" min="1" max="5" type="number"
                    class="form-control @error('rating') is-invalid @enderror" name="rating" required
                    value="{{ old('rating', $client->rating ?? '') }}">
                @error('rating')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="url" class="required">Url</label>
                <input id="url" type="url" class="form-control @error('url') is-invalid @enderror"
                    name="url" required value="{{ old('url', $client->url ?? '') }}">
                @error('url')
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
        new showFilePreview([
            {
                inputSelector: "form .file-preview",
                imgContainer: "#post-img"
            }
        ]);
        new showFilePreview([
            {
                inputSelector: "form .file-preview1",
                imgContainer: "#post-logo"
            }
        ]);
    </script>
@endpush
