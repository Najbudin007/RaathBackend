@extends('admin.layouts.main')

@section('title')
    {{ Str::headline(request()->segment(2)) }}
@stop
@section('styles')
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@stop
@section('content')

    <div class="row small-spacing">
        <div class="col-xs-12">
            <div class="box-content">
                <div class="clearfix bg-lighter">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0 text-uppercase">blogcategory List</h3>
                        <a href="{{ route('admin.blog_categories.create') }}" class="btn btn-primary"> <i
                                class="ri-add-box-line"></i> Add
                            New</a>
                    </div>
                </div>
                <hr>
                <table id="scroll-horizontal-datatable" class="table table-responsive table-striped table-bordered display"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                            <th>{{ ucwords(str_replace('_', ' ', 'status')) }}</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>{{ ucwords(str_replace('_', ' ', 'name')) }}</th>
                            <th>{{ ucwords(str_replace('_', ' ', 'status')) }}</th>

                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($blogcategories as $key=>$blogcategory)
                            <tr id="row_{{ $key }}">
                                <td>{{ $blogcategory->name }}</td>
                                <td><span class="badge bg-{{ $blogcategory->status == 1 ? 'success' : 'danger' }}">
                                        {{ $blogcategory->status == 1 ? 'Active' : 'Inactive' }}
                                    </span></td>

                                <td>
                                    <a href="{{ route('admin.blog_categories.edit', $blogcategory->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <button type="button"
                                        onclick="confirmDelete('{{ route('admin.blog_categories.destroy', $blogcategory->id) }}', {{ $key }},'{{ csrf_token() }}')"
                                        class="btn btn-danger btn-sm" title="Delete"><i
                                            class="fa fa-times"></i>Delete</button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No data found</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <!-- /.box-content -->
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>

    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>
@endsection
