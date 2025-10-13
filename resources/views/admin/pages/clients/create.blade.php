@extends('admin.layouts.main')

@section('title')
    {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.clients._form', [
            'action' => route('admin.clients.store'),
            'method' => 'POST',
            'statusOptions'=> $statusOptions,
            'buttonText' => 'Create {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@endsection