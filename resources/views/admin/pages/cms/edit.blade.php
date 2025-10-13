@extends('admin.layouts.main')
@section('title', 'Edit Page')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit: {{ $cmsPage->title }}</h4>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.cms-pages.update', $cmsPage->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.cms._form')
    </form>
@endsection

