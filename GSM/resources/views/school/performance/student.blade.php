@extends('school.layouts.master')
@section('title', $student->student_name . ' - Performance Report')

@section('content')
<div class="card shadow border-0">
    <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $student->student_name }} ({{ $student->section->section_name }})</h5>
        <span class="badge bg-light text-success fs-6">{{ $finalMedal }} Medal 🏅</span>
    </div>

     <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="">
                    <tr> 
                        <th>Domain</th>
                        <th>Performance</th>
                        <th>Percentage (%)</th>
                    </tr>
                </thead> 
               
                <tbody>
                    @foreach ($domainPerformances as $domain)
                 
                   @php
                    if ($domain['domain'] === 'Water') {
                        $unit = ' Liters';
                    } elseif ($domain['domain'] === 'Energy') {
                        $unit = ' kWh';
                    } elseif ($domain['domain'] === 'Waste') {
                        $unit = ' KG';
                    } else {
                        $unit = '';
                    }
                @endphp

                        <tr>
                            <td>{{ $domain['domain'] }}</td>
                      <td>{{ number_format($domain['saved'], 2) . $unit }}</td>
                             <td>{{ $domain['percentage'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <h5>Overall Average: <strong>{{ round($averagePerformance, 2) }}%</strong></h5>
            <p class="text-muted mb-0">
                Final Medal: <span class="fw-bold text-success">{{ $finalMedal }} 🏅</span>
            </p>
        </div>
    </div>
</div>
@endsection
