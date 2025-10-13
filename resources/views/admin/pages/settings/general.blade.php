<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="col-form-label" for="name">Name</label>
            <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                placeholder="" value="{{ $setting->name ?: old('name') }}">
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="mb-3">
            <label class="col-form-label" for="email">Email</label>
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                placeholder="info@domain.com" value="{{ $setting->email ?: old('email') }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="mb-3">
            <label class="col-form-label" for="address">Address</label>
            <input type="text" name="address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                placeholder="" value="{{ $setting->address ?: old('address') }}">
            @if ($errors->has('address'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
        <div class="mb-3">
            <label class="col-form-label" for="phone">Phone</label>
            <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                placeholder="" value="{{ $setting->phone ?: old('phone') }}">
            @if ($errors->has('phone'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
        <div class="mb-3">
            <label for="meta_title" class="col-form-label">Meta Title</label>
            <input id="meta_title" type="text" class="form-control @error('meta_title') is-invalid @enderror"
                name="meta_title" value="{{ old('meta_title', $team->meta_title ?? '') }}">
            @error('meta_title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="meta_description" class="col-form-label">Meta Description</label>
            <input id="meta_description" type="text"
                class="form-control @error('meta_description') is-invalid @enderror" name="meta_description"
                value="{{ old('meta_description', $team->meta_description ?? '') }}">
            @error('meta_description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="meta_keyword" class="col-form-label">Meta Keyword</label>
            <input id="meta_keyword" type="text" class="form-control @error('meta_keyword') is-invalid @enderror"
                name="meta_keyword" value="{{ old('meta_keyword', $team->meta_keyword ?? '') }}">
            @error('meta_keyword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="logo" class="col-form-label">Logo</label>
            <input id="logo" type="file" accept="image/*"
                class="form-control file-preview @error('logo') is-invalid @enderror" name="logo">
            <div class="form-text text-danger">{{ Str::img_size('settings_logo') }}</div>
            @error('logo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <div id="post-img">
                @if (isset($setting) && $setting->logo)
                    <img src="{{ Str::storage_path($setting->logo) }}" height="200px" width="auto">
                @else
                    <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                @endif
            </div>
        </div>

        <div class="mb-3">
            <label for="favicon" class="col-form-label">Favicon</label>
            <input id="favicon" type="file" accept="image/*"
                class="form-control fav-preview @error('favicon') is-invalid @enderror" name="favicon">
            <div class="form-text text-danger">{{ Str::img_size('settings_favicon') }}</div>
            @error('favicon')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <div id="fav-img">
                @if (isset($setting) && $setting->favicon)
                    <img src="{{ Str::storage_path($setting->favicon) }}" height="200px" width="auto">
                @else
                    <img src="{{ asset('assets/img-preview.jpg') }}" height="200px" width="auto">
                @endif
            </div>
        </div>

    </div>
</div>
