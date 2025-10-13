@extends('admin.layouts.main')
@section('title', 'Page Details')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <div class="btn-group">
                        <a href="{{ route('admin.cms-pages.edit', $cmsPage->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
                <h4 class="page-title">{{ $cmsPage->title }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div>{!! nl2br(e($cmsPage->content)) !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h4>Page Info</h4></div>
                <div class="card-body">
                    <p><strong>Slug:</strong> <code>/{{ $cmsPage->slug }}</code></p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $cmsPage->is_active ? 'success' : 'secondary' }}">
                            {{ $cmsPage->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                    <p><strong>Created:</strong> {{ $cmsPage->created_at->format('M d, Y') }}</p>
                    <p><strong>Updated:</strong> {{ $cmsPage->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
            @if($cmsPage->meta_title || $cmsPage->meta_description)
            <div class="card mt-3">
                <div class="card-header"><h4>SEO</h4></div>
                <div class="card-body">
                    @if($cmsPage->meta_title)
                        <p><strong>Meta Title:</strong> {{ $cmsPage->meta_title }}</p>
                    @endif
                    @if($cmsPage->meta_description)
                        <p><strong>Meta Description:</strong> {{ $cmsPage->meta_description }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

