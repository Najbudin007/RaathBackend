@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h1>Google Analytics Dashboard</h1>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Visitors & Page Views (Last 30 Days)</div>
                <div class="card-body">
                    <canvas id="visitorsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Top Pages</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($topPages as $page)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ Str::limit($page['pageTitle'], 40) }}
                                <span class="badge bg-primary rounded-pill">{{ $page['screenPageViews'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Traffic Sources</div>
                <div class="card-body">
                    <canvas id="sourcesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Visitors Chart
    new Chart(document.getElementById('visitorsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($visitors->pluck('date')->map(fn($date) => $date->format('M d'))) !!},
            datasets: [
                {
                    label: 'Visitors',
                    data: {!! json_encode($visitors->pluck('activeUsers')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },
                {
                    label: 'Page Views',
                    data: {!! json_encode($visitors->pluck('screenPageViews')) !!},
                    borderColor: 'rgb(54, 162, 235)',
                    tension: 0.1
                }
            ]
        }
    });
    // Traffic Sources Chart
    new Chart(document.getElementById('sourcesChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($trafficSources->pluck('pageReferrer')) !!},
            datasets: [{
                data: {!! json_encode($trafficSources->pluck('screenPageViews')) !!},
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                ]
            }]
        }
    });
</script>
@endpush
@endsection