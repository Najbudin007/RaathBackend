@extends('admin.layouts.main')
@section('title')
    Add Gallery Item
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
                <h4 class="page-title">Add New Gallery Item</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.pages.gallery._form')
    </form>
@endsection

