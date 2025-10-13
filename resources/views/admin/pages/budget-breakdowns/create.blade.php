@extends('admin.layouts.main')
@section('title', 'Add Budget')
@section('content')
    <h4>Add Budget Breakdown</h4>
    <form action="{{ route('admin.budget-breakdowns.store') }}" method="POST">@csrf @include('admin.pages.budget-breakdowns._form')</form>
@endsection

