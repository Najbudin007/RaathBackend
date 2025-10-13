@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.job_roles._form', [
            'title' => 'Edit Post',
            'action' => route('admin.job_roles.update', $jobRole->id),
            'method' => 'PUT',
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop