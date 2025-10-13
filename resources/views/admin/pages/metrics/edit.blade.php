@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop
@section('content')
    <div class="container-fluid">
        @include('admin.pages.metrics._form', [
            'title' => 'Edit Post',
            'action' => route('admin.metrics.update', $metric->id),
            'method' => 'PUT',
            'metrics' => $metric,
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop