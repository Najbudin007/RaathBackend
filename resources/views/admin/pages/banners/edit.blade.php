@extends('admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="container col-md-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Edit {{ ucFirst(request()->segment(2)) }}</h3>
        </div>
        <!-- /.card-header -->
        @include('admin.pages.banners._form', [
            'action' => route('admin.banners.update', $banner->id),
            'method' => 'PUT',
            'banner' => $banner, // Pass the existing banner object for edit
            'buttonText' => 'Update',
        ])
    </div>
</div>
@endsection

