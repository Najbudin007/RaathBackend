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
                    name="name" required value="{{ old('name', $team->name ?? '') }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="position" class="required">Position</label>
                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror"
                    name="position" required value="{{ old('position', $team->position ?? '') }}">
                @error('position')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="required">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $team->description ?? '') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="status" class="required">Status</label>
                <select id="sts" name="status" class="form-select" required>
                    <option value="">Select Status</option>
                    @foreach ($statusOptions as $name => $value)
                        <option value="{{ $value }}"
                            {{ (isset($team) && $team->status == $value) || old('status') == $value ? 'selected' : '' }}>
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
                <label for="image" class="">Image</label>
                <input id="image" type="file" accept="image/*"
                    class="form-control file-preview @error('image') is-invalid @enderror" name="image">
                <div id="" class="form-text text-danger">{{ Str::img_size('teams') }}</div>
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label class=""></label>
                <div class="col-sm-auto">
                    <div id="post-img">
                        @if (isset($team) && $team->image)
                            <img src="{{ Str::storage_path($team->image) }}" height="200px" width="auto">
                        @else
                            <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                        @endif
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email', $team->email ?? '') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="facebook" class="">facebook</label>
                <input id="facebook" type="text" class="form-control @error('facebook') is-invalid @enderror"
                    name="facebook" value="{{ old('facebook', $team->facebook ?? '') }}">
                @error('facebook')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="linkedin" class="">Linkedin</label>
                <input id="linkedin" type="text" class="form-control @error('linkedin') is-invalid @enderror"
                    name="linkedin" value="{{ old('linkedin', $team->linkedin ?? '') }}">
                @error('linkedin')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="website" class="">Website</label>
                <input id="website" type="text" class="form-control @error('website') is-invalid @enderror"
                    name="website" value="{{ old('website', $team->website ?? '') }}">
                @error('website')
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
    <script>
        $("form .file-preview").on("change", function() {
            let validImageType = ['jpeg', 'jpg', 'bmp', 'gif', 'svg', 'webp', 'png'];
            let ext = $(this).val().split('.').pop();
            if (!validImageType.includes(ext)) {
                alert('Invalid Image');
                return;
            }
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            let image = new FileReader();
            image.onload = function(e) {
                $('#post-img img').attr('src', e.target.result);
            };
            image.readAsDataURL(this.files[0]);
        });
    </script>
@endpush
