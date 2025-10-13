@extends('admin.layouts.main')

@section('title')
    {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.metrics._form', [
            'action' => route('admin.metrics.store'),
            'method' => 'POST',
            'buttonText' => 'Create {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@endsection