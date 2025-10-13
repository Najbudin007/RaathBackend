@extends('admin.layouts.main')
@section('title', 'Upload Document')
@section('content')
    <h4>Upload Document</h4>
    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">@csrf @include('admin.pages.documents._form')</form>
@endsection

