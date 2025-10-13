@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.service_categories._form', [
            'title' => 'Edit Post',
            'action' => route('admin.service_categories.update', $serviceCategory->id),
            'method' => 'PUT',
            'serviceCategory' => $serviceCategory,
            'statusOptions'=> $statusOptions,
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop