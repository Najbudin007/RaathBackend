@extends('admin.layouts.main')

@section('title')
    {{ Str::headline(request()->segment(2)) }}
@stop
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-end btn-group">
                            <a href="{{ route('admin.banners.create') }}" class="float-end btn btn-md btn-primary"><i
                                    class="fa fa-plus"></i> Create {{ Str::headline(request()->segment(2)) }}</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="banners" class="table table-sm table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <th></th>

                                    <th>
                                        <input type="text" id="title" value="{{ request('title') }}"
                                            class="form-control form-control-sm" placeholder="Name">
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th> <button type="button" class="btn btn-sm btn-success" onclick="filterData()"><i
                                                class="fa fa-filter"></i> Filter </button> </th>


                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $key => $banner)
                                    <tr id="row_{{ $key }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $banner->title }}</td>
                                        <td> <img src="{{Str::storage_path($banner->image)}}" alt="" height="100"></td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $banner->status == 1 ? 'success' : 'danger' }}">{{ \App\Enums\StatusEnum::name($banner->status) }}
                                            </span>
                                        </td>
                                        <td>

                                            <div class="btn-group">
                                                <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                                    class="btn btn-primary btn-sm" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <button type="button"
                                                    onclick="confirmDelete('{{ route('admin.banners.destroy', $banner->id) }}', {{ $key }},'{{ csrf_token() }}')"
                                                    class="btn btn-danger btn-sm" title="Delete"><i
                                                        class="fa fa-times"></i></button>
                                            </div>

                                        </td>
                                    </tr>

                                @empty
                                    <td colspan="3">No Record found</td>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        {{ $banners->links() }}
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>
@endsection
