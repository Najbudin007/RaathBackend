@extends('admin.layouts.main')
@section('title', 'Edit Budget')
@section('content')
    <h4>Edit Budget Breakdown</h4>
    <form action="{{ route('admin.budget-breakdowns.update', $budgetBreakdown->id) }}" method="POST">@csrf @method('PUT') @include('admin.pages.budget-breakdowns._form')</form>
@endsection

