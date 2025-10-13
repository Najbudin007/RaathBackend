@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop

@section('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css" />
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.services._form', [
            'title' => 'Edit Post',
            'action' => route('admin.services.update', $service->id),
            'method' => 'PUT',
            'Service' => $service,
            'statusOptions'=> $statusOptions,
            'categories' => $categories,
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
