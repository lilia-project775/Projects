 @extends('admin.layouts.master')
    
@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <!--<h3 class="text-center fw-bold mb-4">Class-wise Domain Performance</h3>-->
   <div class="row justify-content-end ">
   <div class="col-md-4 ">
      <form method="GET" action="{{ route('admin.dashboard') }}">
    <select name="school_id" onchange="this.form.submit()" class="form-control">
        @foreach($allSchools as $school)
            <option value="{{ $school->id }}" {{ $schoolId == $school->id ? 'selected' : '' }}>
                {{ $school->school_name }}
            </option>
        @endforeach
    </select>
</form>

</div> 

</div>
<hr class="shadow mb-4">

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    let charts = {}; // global object to store chart instances

    const colorPalettes = {
        Water: ['#2196F3', '#42A5F5', '#64B5F6', '#90CAF9', '#BBDEFB'],
        Energy: ['#FFC107', '#FFB300', '#FF9800', '#F57C00', '#FFCC80'],
        Waste: ['#4CAF50', '#66BB6A', '#81C784', '#A5D6A7', '#C8E6C9']
    };

    function renderCharts(chartData, domainSums) {
        Object.entries(chartData).forEach(([domain, data]) => {
            const ctx = document.getElementById(`chart_${domain.toLowerCase()}`);

            // destroy old chart if exists
            if (charts[domain]) {
                charts[domain].destroy();
            }

            const labels = data.map(item => item.class);
            const values = data.map(item => item.percentage);
            const palette = colorPalettes[domain];
            const colors = labels.map((_, i) => palette[i % palette.length]);

            charts[domain] = new Chart(ctx, {
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
    }

    // Initial charts render (from PHP)
    renderCharts(@json($chartData), @json($domainSums));

    // AJAX filter
    $(document).ready(function() {
        $('#school_id').on('change', function() {
            let selectedSchoolId = $(this).val();
            if (!selectedSchoolId) return alert("Please select a school!");

            $.ajax({
                url: "{{ route('admin.school.wise.performance.filter') }}",
                type: "GET",
                data: { school_id: selectedSchoolId },
                success: function(response) {
                    if (response.success) {
                        // re-render charts with new data
                        renderCharts(response.chartData, response.domainSums);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    toastr.success("Something went wrong while filtering!");
                }
            });
        });
    });
</script>


@endsection
