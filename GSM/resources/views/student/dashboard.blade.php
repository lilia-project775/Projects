@extends('student.layouts.master')
@section('title', 'My Savings')

@section('content')
<div class="container-fluid px-4 mt-5 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header custom-bg text-white fw-bold text-center py-3">
                    My Total Performances (Water, Waste & Energy)
                </div>
                <div class="card-body text-center p-4">
                    <div style="max-width: 100%; height: 300px; display: flex; justify-content: center; align-items: center;">
                        <canvas id="savingsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js + Data Labels Plugin --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    const ctx = document.getElementById('savingsChart').getContext('2d');

    const labels = ['Water', 'Waste', 'Energy'];
    const data = [{{ $waterTotal }}, {{ $wasteTotal }}, {{ $energyTotal }}];

    const units = {
        'Water': 'Liters',
        'Waste': 'Kg',
        'Energy': 'kWh'
    };

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#2196F3', '#4CAF50', '#FFC107'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            maintainAspectRatio: false, // ✅ keeps chart inside card without overflow
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 14 } }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            let label = ctx.label || '';
                            let value = ctx.parsed || 0;
                            let unit = units[label] || '';
                            return `${label}: ${value} ${unit} saved`;
                        }
                    }
                },
                datalabels: {
                    color: '#fff',
                    font: { weight: 'bold', size: 14 },
                    formatter: (value, context) => {
                        const label = context.chart.data.labels[context.dataIndex];
                        const unit = units[label] || '';
                        return `${value} ${unit}`;
                    },
                    textAlign: 'center'
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>

{{-- Optional: CSS to prevent page scroll --}}
<style>
    html, body {
        overflow-x: hidden;
        overflow-y: auto;
    }
    .card {
        max-height: 100%;
    }
</style>
@endsection
