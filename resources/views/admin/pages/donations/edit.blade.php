@extends('admin.layouts.main')
@section('title', 'Edit Donation')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit Donation</h4>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.donations.update', $donation->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.donations._form')
    </form>
@endsection

