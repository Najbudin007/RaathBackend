@extends('admin.layouts.main')

@section('title')
    {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.portfolio_categories._form', [
            'action' => route('admin.portfolio_categories.store'),
            'method' => 'POST',
            'statusOptions'=> $statusOptions,
            'buttonText' => 'Create {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@endsection