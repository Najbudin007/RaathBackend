@extends('admin.layouts.main')

@section('title')
    {{ Str::headline(request()->segment(2)) }}
@stop
@section('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css" />
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.books._form', [
            'action' => route('admin.books.store'),
            'method' => 'POST',
            'statusOptions' => $statusOptions,
            'buttonText' => 'Create {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@endsection

@section('scripts')
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

@stop
