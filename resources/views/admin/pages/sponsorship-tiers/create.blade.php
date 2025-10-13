@extends('admin.layouts.main')
@section('title', 'Add Tier')
@section('content')
    <h4>Create Sponsorship Tier</h4>
    <form action="{{ route('admin.sponsorship-tiers.store') }}" method="POST">
        @csrf
        @include('admin.pages.sponsorship-tiers._form')
    </form>
@endsection

