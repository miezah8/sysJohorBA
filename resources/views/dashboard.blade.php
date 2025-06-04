@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h4>Welcome, {{ Auth::user()->name }}!</h4>

    <div class="container-fluid py-4">
        <div class="row">
            {{-- Card: Total Athletes --}}
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-7 text-start">
                                <p class="text-sm mb-1 text-capitalize font-weight-bold">Athletes</p>
                                <h5 class="font-weight-bolder mb-0">
                                     {{ $totalAthletes }}
                                   
                                </h5>
                                <span class="text-sm text-success font-weight-bolder mt-auto mb-0">
                                    {{-- optionally show percent change --}}
                                </span>
                            </div>
                            <div class="col-5 text-end">
                                <i class="fa-solid fa-person-walking fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Total Coaches --}}
            <div class="col-sm-4 mt-sm-0 mt-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-7 text-start">
                                <p class="text-sm mb-1 text-capitalize font-weight-bold">Coaches</p>
                                <h5 class="font-weight-bolder mb-0">
                                     {{ $totalCoaches }} 
                                </h5>
                                <span class="text-sm text-success font-weight-bolder mt-auto mb-0">
                                    {{-- optionally show percent change --}}
                                </span>
                            </div>
                            <div class="col-5 text-end">
                                <i class="fa-solid fa-person-chalkboard fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Total Clubs --}}
            <div class="col-sm-4 mt-sm-0 mt-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-7 text-start">
                                <p class="text-sm mb-1 text-capitalize font-weight-bold">Clubs</p>
                                <h5 class="font-weight-bolder mb-0">
                                     {{ $totalClubs }} 
                                </h5>
                                <span class="text-sm text-success font-weight-bolder mt-auto mb-0">
                                    {{-- optionally show percent change --}}
                                </span>
                            </div>
                            <div class="col-5 text-end">
                                <i class="fa-solid fa-people-group fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Second row: a simple bar chart “Athletes per Club” --}}
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Athletes per Club</h6>
                    </div>
                    <div class="card-body p-3">
                        <canvas id="athletesByClubChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prepare labels & data arrays from the passed‐in $athletesPerClub
        const clubLabels = {!! json_encode($athletesPerClub->keys()) !!};
        const clubData   = {!! json_encode($athletesPerClub->values()) !!};

        const ctx = document.getElementById('athletesByClubChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: clubLabels,
                datasets: [{
                    label: 'Number of Athletes',
                    data: clubData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                  legend: { display: false },
                },
                scales: {
                    y: {
                      beginAtZero: true,
                      ticks: { stepSize: 1 }
                    }
                }
            }
        });
    });
</script>
@endpush
