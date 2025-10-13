@extends('admin.layouts.main')
@section('title', 'Edit Tier')
@section('content')
    <h4>Edit Tier</h4>
    <form action="{{ route('admin.sponsorship-tiers.update', $sponsorshipTier->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.sponsorship-tiers._form')
    </form>
@endsection

