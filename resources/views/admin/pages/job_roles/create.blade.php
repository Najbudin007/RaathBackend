@extends('admin.layouts.main')

@section('title')
    {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.job_roles._form', [
            'action' => route('admin.job_roles.store'),
            'method' => 'POST',
            'buttonText' => 'Create {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@endsection