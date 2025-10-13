@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.tags._form', [
            'title' => 'Edit Post',
            'action' => route('admin.tags.update', $tag->id),
            'method' => 'PUT',
            'tag' => $tag,
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop