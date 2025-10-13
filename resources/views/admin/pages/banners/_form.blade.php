<div class="card-body">
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @if ($method === 'PUT')
            @method('PUT')
        @endif

        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title <span class="required">*</span></label>
            <div class="col-sm-10">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $banner->title ?? '') }}" placeholder="Banner Title">

                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="url" class="col-sm-2 col-form-label">Url</label>
            <div class="col-sm-10">
                <input id="url" type="url" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url', $banner->url ?? '') }}" placeholder="Banner Url">

                @error('url')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea id="description" name="description" cols="auto" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $banner->description ?? '') }}</textarea>

                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label">Banner Image <span class="required">*</span></label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <input id="post-image" type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image" placeholder="Upload Image" autocomplete="image">
                    <small class="text-danger">Appropriate Image Dimension: 1024x by 720px</small>
                    <label class="custom-file-label" for="image">Choose Image</label>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-auto">
                <div id="post-img">
                    @if (isset($banner) && $banner->image)
                        <img src="{{ Str::storage_path($banner->image) }}" height="200px" width="auto">
                    @else
                        <img src="" height="200px" width="auto">
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Status <span class="required">*</span></label>
            <div class="col-sm-10">
                <select name="status" class="form-control" id="status">
                    @foreach ($bannerStatus as $name => $value)
                        <option value="{{ $value }}" {{ (isset($banner) && $banner->status == $value) || old('status') == $value ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>

                @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-2">
                <button type="submit" class="btn btn-primary">
                    {{ $buttonText }}
                </button>
            </div>
        </div>
    </form>
</div>


@section('scripts')
<script>
    $(document).ready(function() {
        $(".custom-file-input").on("change", function() {
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
            }
            image.readAsDataURL(this.files[0]);
        });
    });
</script>
@endsection