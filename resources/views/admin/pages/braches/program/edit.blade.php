@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.teams._form', [
            'title' => 'Edit Post',
            'action' => route('admin.teams.update', $team->id),
            'method' => 'PUT',
            'team' => $team,
            'statusOptions'=> $statusOptions,
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop