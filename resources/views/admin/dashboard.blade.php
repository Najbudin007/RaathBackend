@extends('admin.layouts.main')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />
@stop

@section('content')
    <div class="container-fluid">

        <div class="row">
            <!-- Summary Cards -->
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card border-left-primary shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <div>
                                <div class="text-xs font-weight-bold text-primary mb-1">Subscribers</div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($users) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card border-left-success shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-newspaper fa-2x text-success"></i>
                            </div>
                            <div>
                                <div class="text-xs font-weight-bold text-success mb-1">Posts</div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($posts) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card border-left-info shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                            <div>
                                <div class="text-xs font-weight-bold text-info mb-1">Teams</div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($teams) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card border-left-warning shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-map-signs fa-2x text-warning"></i>
                            </div>
                            <div>
                                <div class="text-xs font-weight-bold text-warning mb-1">Portfolios</div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($portfolios) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card border-left-danger shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-images fa-2x text-danger"></i>
                            </div>
                            <div>
                                <div class="text-xs font-weight-bold text-danger mb-1">Services</div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($services) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                <div class="card border-left-danger shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <div>
                                <div class="text-xs font-weight-bold text-danger mb-1">Clients</div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($clients) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('page_styles')
        <style>
            .card {
                border-radius: 0.5rem;
                transition: transform 0.2s;
            }

            .card:hover {
                transform: translateY(-5px);
            }

            .chart-container {
                min-height: 400px;
            }
        </style>
    @endpush


@endsection
