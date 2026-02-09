@extends('school.layouts.master')
@section('title', 'School Dashboard')

@section('content')
<div class="container mt-5">
    <!--<h3 class="text-center fw-bold mb-4">Class-wise Domain Performance</h3>-->

    <div class="row text-center">
        @foreach(['Water', 'Waste', 'Energy'] as $domain)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header 
                        @if($domain === 'Water') bg-info 
                        @elseif($domain === 'Energy') bg-warning 
                        @elseif($domain === 'Waste') bg-success 
                        @endif
                        text-white fw-bold">
                        {{ $domain }} Domain
                    </div>
                    <div class="card-body">
                        <canvas id="chart_{{ strtolower($domain) }}" height="230"></canvas>
                    </div> 
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- CHART SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    const chartData = @json($chartData);
    const domainSums = @json($domainSums);

    const colorPalettes = {
        Water: ['#2196F3', '#42A5F5', '#64B5F6', '#90CAF9', '#BBDEFB'],
        Energy: ['#FFC107', '#FFB300', '#FF9800', '#F57C00', '#FFCC80'],
        Waste: ['#4CAF50', '#66BB6A', '#81C784', '#A5D6A7', '#C8E6C9']
    };

    Object.entries(chartData).forEach(([domain, data]) => {
        const ctx = document.getElementById(`chart_${domain.toLowerCase()}`);
        const labels = data.map(item => item.class);
        const values = data.map(item => item.percentage);

        const palette = colorPalettes[domain];
        const colors = labels.map((_, i) => palette[i % palette.length]);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: { boxWidth: 20, padding: 10 }
                    },
                    title: {
                        display: true,
                        text: `${domain} Domain - Class-wise Performance (Total: ${domainSums[domain].toFixed(2)}%)`,
                        color: '#333',
                        font: { size: 16, weight: 'bold' },
                        padding: { top: 10, bottom: 20 }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.parsed}%`
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: { weight: 'bold', size: 13 },
                        formatter: value => `${value}%`
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>
@endsection
