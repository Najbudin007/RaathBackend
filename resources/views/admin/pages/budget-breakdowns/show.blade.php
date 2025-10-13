@extends('admin.layouts.main')
@section('title', 'Budget Details')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4>{{ $budgetBreakdown->category }}</h4>
            <p>Project: {{ $budgetBreakdown->project->title }}</p>
            <h5>${{ number_format($budgetBreakdown->amount, 2) }}</h5>
            <p>{{ $budgetBreakdown->description }}</p>
            <a href="{{ route('admin.budget-breakdowns.edit', $budgetBreakdown->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.budget-breakdowns.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection

