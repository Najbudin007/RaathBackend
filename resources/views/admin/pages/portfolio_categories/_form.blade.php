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
    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" required value="{{ old('title' , $portfolioCategory->title ?? '')}}">
    @error('title')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>    <div class="mb-3">
    <label for="status" class="required">Status</label>
    <select id="sts" name="status" class="form-select" required>
        <option value="">Select Status</option>
        @foreach ($statusOptions as $name => $value)
            <option value="{{$value}}" {{ (isset($portfolioCategory) && $portfolioCategory->status == $value) || old('status') == $value ? 'selected' : '' }}>{{$name}}</option>
        @endforeach
    </select>   
    @error('status')
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