@extends('admin.layouts.main')
@section('title', 'Edit Subscriber')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit Subscriber</h4>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.subscribers.update', $subscriber->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages.subscribers._form')
    </form>
@endsection

