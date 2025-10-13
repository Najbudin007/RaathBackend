<div class="card border-primary border">
    <h4 class="card-header bg-lighttext-primary"> {{$method === 'PUT' ? 'Edit': 'Create New' }} </h4>
    <div class="card-body">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if ($method === 'PUT')
                @method('PUT')
            @endif

            <div class="mb-3">
    <label for="title" class="required">Title</label>
    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" required value="{{ old('title' , $jobRole->title ?? '')}}">
    @error('title')
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