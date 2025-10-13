@extends('admin.layouts.main')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/media-library.css') }}">
@endsection
@section('content')
    <div id="loader" class="d-none">Loading...</div>
    <div class="container">
        <h1 class="mb-4">Media Library</h1>

        <nav aria-label="breadcrumb">
            <ol id="breadcrumb" class="breadcrumb"></ol>
        </nav>

        {{-- <div class="actions mb-4">
            <input type="text" id="folder-name" class="form-control" placeholder="Enter folder name">
            <button id="create-folder" class="btn btn-primary mt-2">Create Folder</button>
            <button id="upload-image-btn" class="btn btn-secondary mt-2">Upload Image</button>
            <input type="file" id="image-file" class="d-none" accept="image/*,.pdf">
        </div> --}}

        <div id="folder-grid" class="row folder-grid"></div>
        <div id="images" class="row"></div>
        <div id="documents" class="row"></div>

        <div class="context-menu" id="context-menu">
            <div class="context-menu-item" id="delete-folder">Delete Folder</div>
        </div>
    </div>

    @include('admin.partials.image-modal')

@endsection
@section('scripts')
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/media-library.js') }}"></script>
@stop
