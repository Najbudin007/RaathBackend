@extends('admin.layouts.main')

@section('title', 'View Blog')

@section('content')
<div class="container">
    <h1>{{ $blog->title }}</h1>
    <p>{{ $blog->content }}</p>
    <p><strong>Meta Title:</strong> {{ $blog->meta_title }}</p>
    <p><strong>Meta Description:</strong> {{ $blog->meta_description }}</p>
    <p><strong>Meta Keywords:</strong> {{ $blog->meta_keywords }}</p>
    @if ($blog->featured_image)
        <img src="{{ asset($blog->featured_image) }}" alt="Featured Image" class="img-thumbnail" style="max-width: 200px;">
    @endif
</div>
@endsection