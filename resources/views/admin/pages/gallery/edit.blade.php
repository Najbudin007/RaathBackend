@extends('admin.layouts.main')
@section('title')
    Edit Gallery Item - {{ $gallery->title }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Back to Gallery
                    </a>
                </div>
                <h4 class="page-title">Edit Gallery Item: {{ $gallery->title }}</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.pages.gallery._form')
    </form>
@endsection

