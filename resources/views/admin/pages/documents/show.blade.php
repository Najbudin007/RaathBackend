@extends('admin.layouts.main')
@section('title', 'Document Details')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4>{{ $document->title }}</h4>
            <p>File: {{ $document->file_name }}</p>
            <p>Size: {{ number_format($document->file_size / 1024, 2) }} KB</p>
            <p>Downloads: {{ $document->download_count }}</p>
            <a href="{{ asset('storage/' . $document->file_url) }}" target="_blank" class="btn btn-info">Download</a>
            <a href="{{ route('admin.documents.edit', $document->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection

