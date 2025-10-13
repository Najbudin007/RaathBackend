@extends('admin.layouts.main')
@section('title')
    Edit Yatra - {{ $yatra->title }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('admin.yatras.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Back to List
                    </a>
                </div>
                <h4 class="page-title">Edit Yatra: {{ $yatra->title }}</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.yatras.update', $yatra->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.pages.yatras._form')
    </form>
@endsection

