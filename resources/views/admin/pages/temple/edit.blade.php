@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop
@section('content')
    <div class="container-fluid">
        @include('admin.pages.temple._form', [
            'title' => 'Edit Post',
            'action' => route('admin.temples.update', $temple->id),
            'method' => 'PUT',
            'temple' => $temple,
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop
