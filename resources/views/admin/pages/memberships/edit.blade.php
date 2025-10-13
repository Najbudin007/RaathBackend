@extends('admin.layouts.main')
@section('title', 'Edit Membership Plan')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit: {{ $membership->name }}</h4>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.memberships.update', $membership->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.memberships._form')
    </form>
@endsection

