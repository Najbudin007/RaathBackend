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
                        <h3 class="mb-0">Blog List</h3>
                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary"> <i
                            class="ri-add-box-line"></i> Add
                            New</a>
                    </div>
                </div>
                <hr>
                <table id="scroll-horizontal-datatable" class="table table-responsive table-striped table-bordered display"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            {{-- <th>Slug</th> --}}
                            <th>Category</th>
                            <th>Tag</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                            {{-- <th>Slug</th> --}}
                            <th>Category</th>
                            <th>Tag</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($blogs as $key=>$blog)
                            <tr id="row_{{ $key }}">
                                <td>{{ $blog->title }}</td>
                                {{-- <td>{{ $blog->slug }}</td> --}}
                                <td>{{ $blog->category->name ?? '-' }}</td>
                                <th>
                                    @foreach($blog->tags as $tag)
                                    <span class="badge bg-primary">{{ $tag->title }}</span>
                                    @endforeach
                                </th>
                                <td><span class="badge bg-{{ $blog->status == 1 ? 'success' : 'danger' }}">
                                {{ $blog->status == 1 ? 'Active' : 'Inactive' }}
                                </span></td>
                                <td><img src="{{ Str::storage_path($blog->featured_image) }}" style="height: 100px"></td>
                                <td>
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <button type="button"
                                        onclick="confirmDelete('{{ route('admin.blogs.destroy', $blog->id) }}', {{ $key }},'{{ csrf_token() }}')"
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
