@extends('admin.layouts.main')

@section('title')
    {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.tags._form', [
            'action' => route('admin.tags.store'),
            'method' => 'POST',
            'buttonText' => 'Create {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@endsection