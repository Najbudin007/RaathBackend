@extends('admin.layouts.main')
@section('title', 'Edit Document')
@section('content')
    <h4>Edit Document</h4>
    <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.pages.documents._form')</form>
@endsection

