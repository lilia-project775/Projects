@extends('school.layouts.master')
@section('title', $school->school_name . ' Dashboard')

@section('content')
<div class="container mt-5">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header custom-bg text-white py-3 px-4 d-flex justify-content-between align-items-center" >
            <h5 class="mb-0 fw-bold">🏫 {{ $school->school_name }} — Class Performance Overview</h5>
            <span class="badge bg-white text-success fs-6 px-3 py-2 shadow-sm rounded-pill">
                Overall: <strong>{{ $finalMedal }}</strong> 🏅 ({{ round($average, 2) }}%)
            </span>
        </div>
  
        <div class="card-body bg-light">
            @if(count($classNames) > 0)
                <div class="text-center mb-4">
                    <h6 class="fw-semibold text-muted">Class-wise Performance Summary</h6>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-11 col-sm-12">
                        <canvas id="classPerformanceChart" height="150"></canvas>
                    </div>
                </div> 
            @else
                <div class="text-center text-muted py-5">
                    <h6>No performance data available 📊</h6>
                </div>
            @endif
        </div>

        <div class="card-footer bg-white text-end small text-muted">
            Updated on: {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('classPerformanceChart');

    const classNames = @json($classNames);
    const performanceData = @json($performancePercentages);
    const medalTypes = @json($medalTypes);

    const colors = {
        Gold: 'rgba(255, 215, 0, 0.85)',
        Silver: 'rgba(192, 192, 192, 0.85)',
        Bronze: 'rgba(205, 127, 50, 0.85)',
        Default: 'rgba(54, 162, 235, 0.8)'
    };

    const backgroundColors = medalTypes.map(type => colors[type] || colors.Default);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: classNames,
            datasets: [{
                label: 'Performance (%)',
                data: performanceData,
                backgroundColor: backgroundColors,
                borderColor: 'rgba(0, 0, 0, 0.2)',
                borderWidth: 1.5,
                borderRadius: 10,
                hoverBackgroundColor: backgroundColors.map(c => c.replace('0.85', '1')),
            }]
        },
        options: {
            responsive: true,
            animation: { duration: 1500, easing: 'easeOutQuart' },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { color: '#333', font: { size: 13 } },
                    title: {
                        display: true,
                        text: 'Performance (%)',
                        color: '#111',
                        font: { size: 14, weight: 'bold' }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    ticks: { color: '#333', font: { size: 13 } },
                    title: {
                        display: true,
                        text: 'Classes',
                        color: '#111',
                        font: { size: 14, weight: 'bold' }
                    },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    titleFont: { weight: 'bold', size: 14 },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: (ctx) => ` ${ctx.label}: ${ctx.raw}% (${medalTypes[ctx.dataIndex]} Medal 🏅)`
                    }
                },
                title: {
                    display: true,
                    text: 'Class Performance (Visual Representation)',
                    font: { size: 16, weight: 'bold' },
                    color: '#00416A',
                    padding: { top: 10, bottom: 20 }
                }
            }
        }
    });
</script>
@endsection
