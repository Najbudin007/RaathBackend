@extends('admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="container col-md-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">New {{ ucFirst(request()->segment(2)) }}</h3>
        </div>
        <!-- /.card-header -->
        @include('admin.pages.banners._form', [
            'action' => route('admin.banners.store'),
            'method' => 'POST',
            'banner' => new App\Models\Banner(), // Empty banner object for create
            'buttonText' => 'Submit',
        ])
    </div>
</div>
@endsection
