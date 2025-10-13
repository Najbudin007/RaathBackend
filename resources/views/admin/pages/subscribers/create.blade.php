@extends('admin.layouts.main')
@section('title', 'Add Subscriber')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Add Subscriber</h4>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.subscribers.store') }}" method="POST">
        @csrf
        @include('admin.pages.subscribers._form')
    </form>
@endsection

