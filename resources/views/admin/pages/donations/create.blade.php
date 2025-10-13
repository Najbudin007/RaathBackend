@extends('admin.layouts.main')
@section('title', 'Add Donation')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Record New Donation</h4>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.donations.store') }}" method="POST">
        @csrf
        @include('admin.pages.donations._form')
    </form>
@endsection

