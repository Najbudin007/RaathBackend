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
                        <h3 class="mb-0 text-uppercase">subscription List</h3>
                    </div>
                </div>
                <hr>
                <table id="scroll-horizontal-datatable" class="table table-responsive table-striped table-bordered display"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($subscriptions as $key=>$subscription)
                            <tr id="row_{{ $key }}">
                                <td>{{ $subscription->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No data found</td>
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

@endsection
