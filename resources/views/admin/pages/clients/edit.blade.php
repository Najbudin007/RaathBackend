@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.clients._form', [
            'title' => 'Edit Post',
            'action' => route('admin.clients.update', $client->id),
            'method' => 'PUT',
            'client' => $client,
            'statusOptions'=> $statusOptions,
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop