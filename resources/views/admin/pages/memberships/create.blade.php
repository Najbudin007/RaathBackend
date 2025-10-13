@extends('admin.layouts.main')
@section('title', 'Create Membership Plan')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Create Membership Plan</h4>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.memberships.store') }}" method="POST">
        @csrf
        @include('admin.pages.memberships._form')
    </form>
@endsection

