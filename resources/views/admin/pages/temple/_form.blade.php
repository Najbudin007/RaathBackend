<div class="card border-primary border">
    <h4 class="card-header bg-lighttext-primary"> {{ $method === 'PUT' ? 'Edit' : 'Create New' }} </h4>
    <div class="card-body">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if ($method === 'PUT')
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="required">Country</label>
                <input id="name" type="text" class="form-control @error('country') is-invalid @enderror"
                    name="country" required value="{{ old('country', $metrics->country ?? '') }}">
                @error('country')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="value" class="required">Count</label>
                <input id="value" type="text" class="form-control @error('count') is-invalid @enderror"
                    name="count" required value="{{ old('count', $metrics->count ?? '') }}">
                @error('value')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- for region --}}
            <div class="mb-3">
                <label for="region" class="required">Region</label>
                <input id="region" type="text" class="form-control @error('region') is-invalid @enderror"
                    name="region" required value="{{ old('region', $metrics->region ?? '') }}">
                @error('region')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            {{-- for latitude --}}

            <div class="mb-3">
                <label for="latitude" class="required">Latitude</label>
                <input id="latitude" type="text" class="form-control @error('lat') is-invalid @enderror"
                    name="lat" required value="{{ old('lat', $metrics->lat ?? '') }}">
                @error('lat')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            {{-- for longitude --}}

            <div class="mb-3">
                <label for="longitude" class="required">Longitude</label>
                <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror"
                    name="lng" required value="{{ old('lng', $metrics->lng ?? '') }}">
                @error('lng')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    {{ $method === 'PUT' ? 'Update' : 'Submit' }}
                </button>
            </div>
        </form>
    </div>
</div>
