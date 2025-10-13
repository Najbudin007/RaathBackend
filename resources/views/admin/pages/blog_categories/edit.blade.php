@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop
{dd($blogCategory)}
@section('content')
    <div class="container-fluid">
        @include('admin.pages.blog_categories._form', [
            'title' => 'Edit Post',
            'action' => route('admin.blog_categories.update', $blogCategory->id),
            'method' => 'PUT',
            'blogCategory' => $blogCategory,
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop