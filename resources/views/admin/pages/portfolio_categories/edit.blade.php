@extends('admin.layouts.main')

@section('title')
    Edit {{ Str::headline(request()->segment(2)) }}
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.pages.portfolio_categories._form', [
            'title' => 'Edit Post',
            'action' => route('admin.portfolio_categories.update', $portfolioCategory->id),
            'method' => 'PUT',
            'portfolioCategory' => $portfolioCategory,
            'statusOptions'=> $statusOptions,
            'buttonText' => 'Update {{ Str::headline(request()->segment(2)) }}',
        ])
    </div>
@stop