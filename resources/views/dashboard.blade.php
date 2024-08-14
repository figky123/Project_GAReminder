@extends('master')
@section('navbar-title', 'Dashboard')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* CSS untuk mengatur ukuran grafik */
        .chart-container {
            position: relative;
            width: 80%; /* Lebar lebih besar */
            height: 400px; /* Tinggi lebih besar */
            margin: 20px auto;
        }
        /* Mengatur tampilan grafik agar lebih bersih */
        canvas {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="row">
            <!-- Status Tiket Chart -->
            <div class="col-md-6 chart-container">
                <canvas id="statusTiketChart"></canvas>
                <script>
                    var ctx1 = document.getElementById('statusTiketChart').getContext('2d');
                    var statusTiketChart = new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: @json(array_keys($statusTiketData)),
                            datasets: [{
                                label: 'Jumlah Status Tiket',
                                data: @json(array_values($statusTiketData)),
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(153, 102, 255, 0.6)',
                                    'rgba(255, 159, 64, 0.6)'
                                ],
                                borderColor: [
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                tooltip: {
                                    enabled: true,
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>

            <!-- Penumpang berdasarkan Nomor Penerbangan Chart -->
            <div class="col-md-6 chart-container">
                <canvas id="flightChart"></canvas>
                <script>
                    var ctx2 = document.getElementById('flightChart').getContext('2d');
                    var flightChart = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: @json(array_keys($flightCounts)),
                            datasets: [{
                                label: 'Jumlah Penumpang berdasarkan Nomor Penerbangan',
                                data: @json(array_values($flightCounts)),
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(255, 206, 86, 0.6)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                tooltip: {
                                    enabled: true,
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</body>
</html>
@endsection
