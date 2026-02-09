@extends('school.layouts.master')
@section('title', $section->section_name . ' Performance Report')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $section->class->class_name }} - {{ $section->section_name }} Performance</h5>
            <span class="badge bg-light text-success fs-6">{{ $finalMedal }} Medal 🏅</span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="">
                        <tr>
                            <th>Domain</th>
                            <th>Baseline Value</th>
                            <th>Performance</th>
                            <th>Percentage (%)</th>
                            <th>Medal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($performance as $domain => $data)
                            <tr>
                                <td class="fw-semibold">{{ $domain }}</td>
                                <td>{{ number_format($data['baseline'], 2) }}</td>
                                <td>{{ number_format($data['saved'], 2) }}</td>
                                <td>{{ $data['percentage'] }}%</td>
                                <td>
                                    @if ($data['medal'] === 'Gold')
                                        <span class="badge bg-warning text-dark fw-semibold">🥇 Gold</span>
                                    @elseif ($data['medal'] === 'Silver')
                                        <span class="badge bg-secondary text-white fw-semibold">🥈 Silver</span>
                                    @else
                                        <span class="badge bg-bronze text-white fw-semibold">🥉 Bronze</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <h5 class="text-muted mb-2">Overall Performance</h5>
                <p class="fs-5 mb-1">
                    <strong>Average Performance:</strong> {{ round($average, 2) }}%
                </p>
                <p class="fs-5 mb-0">
                    <strong>Final Medal:</strong> 
                    <span class="fw-bold text-success">{{ $finalMedal }} 🏅</span>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.bg-bronze {
    background-color: #cd7f32 !important;
}
</style>
@endsection
