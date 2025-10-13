@extends('admin.layouts.main')
@section('title', 'Add Team Member')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Back to List
                    </a>
                </div>
                <h4 class="page-title">Add Team Member</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.pages.team._form')
    </form>
@endsection

