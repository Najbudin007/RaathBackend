@extends('admin.layouts.main')
@section('title', 'Create Page')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Create New Page</h4>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.cms-pages.store') }}" method="POST">
        @csrf
        @include('admin.pages.cms._form')
    </form>
@endsection

