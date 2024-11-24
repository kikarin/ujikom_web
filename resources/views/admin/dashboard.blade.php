@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
    </div>

    <div class="row">
        <!-- Total Users Card -->
        <div class="col-md-4">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                <div class="card border-primary">
                    <div class="card-body text-primary">
                        <h5 class="card-title"><i class="fas fa-users"></i> Total Users</h5>
                        <h2 class="card-text">{{ $totalUsers ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Agendas Card -->
        <div class="col-md-4">
            <a href="{{ route('dashboard.agendas.index') }}" class="text-decoration-none">
                <div class="card border-success">
                    <div class="card-body text-success">
                        <h5 class="card-title"><i class="fas fa-calendar-check"></i> Total Agendas</h5>
                        <h2 class="card-text">{{ $totalAgendas ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Infos Card -->
        <div class="col-md-4">
            <a href="{{ route('dashboard.infos.index') }}" class="text-decoration-none">
                <div class="card border-info">
                    <div class="card-body text-info">
                        <h5 class="card-title"><i class="fas fa-info-circle"></i> Total Infos</h5>
                        <h2 class="card-text">{{ $totalInfos ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Galleries Card -->
        <div class="col-md-4">
            <a href="{{ route('dashboard.galleries.index') }}" class="text-decoration-none">
                <div class="card border-warning">
                    <div class="card-body text-warning">
                        <h5 class="card-title"><i class="fas fa-images"></i> Total Galleries</h5>
                        <h2 class="card-text">{{ $totalGalleries ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Albums Card -->
        <div class="col-md-4">
            <a href="{{ route('dashboard.albums.index') }}" class="text-decoration-none">
                <div class="card border-danger">
                    <div class="card-body text-danger">
                        <h5 class="card-title"><i class="fas fa-book"></i> Total Albums</h5>
                        <h2 class="card-text">{{ $totalAlbums ?? 0 }}</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="mt-5">
        <h2><i class="fas fa-chart-bar"></i> Overview</h2>
        <div class="row">
            <!-- Placeholder for charts or data visualizations -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-pie"></i> User Distribution</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            <div class="card">
    <div class="card-header bg-success text-white d-flex align-items-center">
        <h5 class="mb-0"><i class="fas fa-chart-line"></i> Recent Activities</h5>
        <span class="ms-auto small">
            <i class="fas fa-clock"></i> Last updated: {{ now('Asia/Jakarta')->format('d M Y, H:i') }} WIB
        </span>
    </div>
    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
        @if(!empty($recentLogs) && count($recentLogs) > 0)
            <ul class="list-group">
                @foreach($recentLogs as $log)
                    <li class="list-group-item d-flex align-items-start">
                        <div class="me-3">
                            <i class="fas fa-circle text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1 text-truncate">{{ $log['message'] }}</p>
                            <small class="text-muted">
                                @if(\Carbon\Carbon::canBeCreatedFromFormat($log['timestamp'], 'Y-m-d H:i:s'))
                                    {{ \Carbon\Carbon::parse($log['timestamp'])->diffForHumans() }} WIB ({{ strtoupper($log['level']) }})
                                @else
                                    Timestamp unavailable
                                @endif
                            </small>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-center text-muted">
                <i class="fas fa-info-circle fa-2x mb-2"></i>
                <p>No recent activities found.</p>
            </div>
        @endif
    </div>
</div>


            </div>
        </div>
    </div>
</div>
</div>

<style>
    .list-group-item {
        background-color: #f9f9f9;
        border: none;
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #eef5ff;
        transform: translateX(5px);
    }

    .list-group-item i {
        font-size: 0.8rem;
    }

    .list-group-item p {
        font-size: 0.95rem;
        margin: 0;
        font-weight: 500;
    }

    .list-group-item small {
        font-size: 0.85rem;
    }

    .card-body {
        scrollbar-width: thin;
        scrollbar-color: #6c757d #f8f9fa;
    }

    .card-body::-webkit-scrollbar {
        width: 8px;
    }

    .card-body::-webkit-scrollbar-thumb {
        background: #6c757d;
        border-radius: 10px;
    }

    .card-body::-webkit-scrollbar-track {
        background: #f8f9fa;
    }

    /* General Card Styling */
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    .card .card-body h5 {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .card .card-body h2 {
        font-size: 2rem;
        font-weight: 700;
    }

    /* Recent Activities Styling */
    .list-group-item {
        background-color: #f9f9f9;
        border: none;
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f1f1f1;
    }

    .text-muted p {
        font-size: 1.1rem;
        font-style: italic;
    }

    /* Custom Scrollbar for Recent Activities */
    .card-body {
        scrollbar-width: thin;
        scrollbar-color: #6c757d #f8f9fa;
    }

    .card-body::-webkit-scrollbar {
        width: 8px;
    }

    .card-body::-webkit-scrollbar-thumb {
        background: #6c757d;
        border-radius: 10px;
    }

    .card-body::-webkit-scrollbar-track {
        background: #f8f9fa;
    }

    /* Chart Section Styling */
    .chart-container {
        position: relative;
        height: 300px;
    }

    .card-header {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .text-decoration-none:hover .card {
        transform: translateY(-10px);
    }

    /* Hover Effect for Cards */
    .card:hover .card-body h5,
    .card:hover .card-body h2 {
        color: #446496;
    }
</style>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('userChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Admins', 'Users'],
            datasets: [{
                label: '# of Users',
                data: [{{ $adminCount ?? 0 }}, {{ $userCount ?? 0 }}],
                backgroundColor: ['#4A90E2', '#50E3C2'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

@endsection