<div class="card border-primary border">
    <h4 class="card-header bg-lighttext-primary"> {{$method === 'PUT' ? 'Edit': 'Create New' }} </h4>
    <div class="card-body">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if ($method === 'PUT')
                @method('PUT')
            @endif

            <div class="mb-3">
    <label for="name" class="required">Name</label>
    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required value="{{ old('name' , $metrics->name ?? '')}}">
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div><div class="mb-3">
    <label for="value" class="required">Value</label>
    <input id="value" type="text" class="form-control @error('value') is-invalid @enderror" name="value" required value="{{ old('value' , $metrics->value ?? '')}}">
    @error('value')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                {{$method === 'PUT' ? 'Update': 'Submit' }} 
                </button>
            </div>
        </form>
    </div>
</div>