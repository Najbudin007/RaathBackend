@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css" />
@endpush
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
                    name="title" required value="{{ old('title', $career->title ?? '') }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="job_type" class="required">Job Type</label>
                <input id="job_type" type="text" class="form-control @error('job_type') is-invalid @enderror"
                    name="job_type" required value="{{ old('job_type', $career->job_type ?? '') }}">
                @error('job_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="position_id" class="required">Position</label>
                <select id="position_id" name="position_id"
                    class="form-control @error('position_id') is-invalid @enderror" required>
                    <option value="">Select Position</option>
                    @foreach ($roleOptions as $value => $name)
                        <option value="{{ $value }}"
                            {{ (isset($career) && $career->position_id == $value) || old('position_id') == $value ? 'selected' : '' }}>
                            {{ $name }}</option>
                    @endforeach
                </select>
                @error('position_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="status" class="required">Status</label>
                <select id="sts" name="status" class="form-control @error('status') is-invalid @enderror"
                    required>
                    <option value="">Select Status</option>
                    @foreach ($statusOptions as $name => $value)
                        <option value="{{ $value }}"
                            {{ (isset($career) && $career->status == $value) || old('status') == $value ? 'selected' : '' }}>
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
                <label for="expired_date" class="required">Expired Date</label>
                <input id="expired_date" type="date" class="form-control @error('expired_date') is-invalid @enderror"
                    name="expired_date" required value="{{ old('expired_date', $career->expired_date ?? '') }}">
                @error('expired_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="required">Description</label>
                <textarea id="description" name="description" class="form-control required">{{ old('description', $career->description ?? '') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 row">
                <label for="image" class="">Image</label>
                <input id="image" type="file" accept="image/*"
                    class="form-control file-preview @error('image') is-invalid @enderror" name="image">
                <div id="" class="form-text text-danger">{{ Str::img_size('careers') }}</div>
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
                        @if (isset($career) && $career->image)
                            <img src="{{ Str::storage_path($career->image) }}" height="200px" width="auto">
                        @else
                            <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                        @endif
                    </div>
                </div>
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
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
            }
        }
    </script>
    <script type="module" src="{{ asset('assets/js/ckeditor-init.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            initializeEditor("#description");
        });
    </script>
@endpush
