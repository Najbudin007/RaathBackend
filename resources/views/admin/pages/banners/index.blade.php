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
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="badge bg-{{ $banner->status == 1 ? 'success' : 'danger' }} me-2">{{ \App\Enums\StatusEnum::name($banner->status) }}
                                                </span>
                                                <button type="button"
                                                    onclick="toggleBannerStatus('{{ route('admin.banners.toggle-status', $banner->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $banner->status ? 'true' : 'false' }})"
                                                    class="btn btn-{{ $banner->status ? 'warning' : 'success' }} btn-sm" 
                                                    title="{{ $banner->status ? 'Deactivate' : 'Activate' }} Banner">
                                                    <i class="ri-{{ $banner->status ? 'pause' : 'play' }}-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                                    class="btn btn-primary btn-sm" title="Edit Banner">
                                                    <i class="ri-edit-line"></i> Edit
                                                </a>
                                                <button type="button"
                                                    onclick="confirmDelete('{{ route('admin.banners.destroy', $banner->id) }}', {{ $key }},'{{ csrf_token() }}')"
                                                    class="btn btn-danger btn-sm" title="Delete Banner">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No banners found</td>
                                    </tr>
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
    <script>
        // Toggle banner status function
        function toggleBannerStatus(url, key, token, currentStatus) {
            const action = currentStatus === 'true' ? 'deactivate' : 'activate';
            
            Swal.fire({
                title: `Are you sure?`,
                text: `Do you want to ${action} this banner?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            '_token': token,
                            '_method': 'POST'
                        },
                        success: function (data) {
                            if (data.success) {
                                // Reload the page to update the status
                                location.reload();
                                Swal.fire(
                                    'Success!',
                                    data.message || `Banner ${action}d successfully.`,
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message || `Failed to ${action} banner.`,
                                    'error'
                                );
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            let errorMessage = `Failed to ${action} banner.`;
                            
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire(
                                'Error!',
                                errorMessage,
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
