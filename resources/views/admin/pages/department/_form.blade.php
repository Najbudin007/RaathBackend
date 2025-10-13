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
                    <label for="name" class="required">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name"  value="{{ old('name', $department->name ?? '') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="status" class="required">Status</label>
                    <select id="sts" name="status" class="form-control @error('status') is-invalid @enderror"
                        >
                        <option value="">Select Status</option>
                        @foreach ($statusOptions as $name => $value)
                            <option value="{{ $value }}"
                                {{ (isset($department) && $department->status == $value) || old('status') == $value ? 'selected' : '' }}>
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
                    <label for="expired_date" class="required"> Time</label>
                    <input id="expired_date" type="text" class="form-control @error('time') is-invalid @enderror"
                        name="time"  value="{{ old('time', $department->time ?? '') }}">
                    @error('time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- for unit --}}
                <div class="mb-3">
                    <label for="unit" class="required">Unit</label>
                    <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror"
                        name="unit"  value="{{ old('unit', $department->unit ?? '') }}">
                    @error('unit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- for requirements  in array --}}

    <div class="mb-3">
                    <label for="achievements" class="required">Requirements</label>
                    <input id="requirements" type="text" class="form-control @error('requirements') is-invalid @enderror"
                        name="requirements[]" required value="{{ old('requirements.0', $team->requirements[0] ?? '') }}">
                    @error('requirements.0')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="required">Description</label>
                    <textarea id="description" name="description" class="form-control ">{{ old('description', $department->description ?? '') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- <div class="mb-3 row">
                    <label for="image" class="">Image</label>
                    <input id="image" type="file" accept="image/*"
                        class="form-control file-preview @error('image') is-invalid @enderror" name="image">
                    <div id="" class="form-text text-danger">{{ Str::img_size('departments') }}</div>
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
                            @if (isset($department) && $department->image)
                                <img src="{{ Str::storage_path($department->image) }}" height="200px" width="auto">
                            @else
                                <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                            @endif
                        </div>
                    </div>
                </div> --}}

                {{-- for color --}}

                <div class="mb-3">
                    <label for="color" class="required">Color</label>
                    <input id="color" type="text" class="form-control @error('color') is-invalid @enderror"
                        name="color"  value="{{ old('color', $department->color ?? '') }}">
                    @error('color')
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
