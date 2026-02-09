@extends('admin.layouts.master')
@section('title', $school->school_name . ' Performance')

@section('content')
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $school->school_name }} — Performance Status</h5>
            <span class="badge bg-light text-success fs-6">{{ $finalMedal }} Medal 🏅</span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Domain</th>
                            <th>Baseline</th>
                            <th>Saved</th>
                            <th>Achievement (%)</th>
                            <th>Medal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($performance as $domain => $data)
                            <tr>
                                <td>
                                    @if ($domain === 'Water')
                                        💧 Water
                                    @elseif ($domain === 'Energy')
                                        ⚡ Energy
                                    @else
                                        ♻️ Waste
                                    @endif
                                </td>
                                <td>{{ number_format($data['baseline'], 2) }}</td>
                                <td>{{ number_format($data['saved'], 2) }}</td>
                                <td>{{ $data['percentage'] }}%</td>
                                <td>
                                    @if ($data['medal'] === 'Gold')
                                        <span class="badge bg-warning text-dark fw-semibold">🥇 Gold</span>
                                    @elseif ($data['medal'] === 'Silver')
                                        <span class="badge bg-secondary fw-semibold text-white">🥈 Silver</span>
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
                <h5>Total Performance: <strong>{{ round($average, 2) }}%</strong></h5>
                <p class="text-muted mb-0">Overall Medal Status:
                    <span class="fw-bold text-success">{{ $finalMedal }} 🏅</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Bronze Color --}}
    <style>
        .bg-bronze {
            background-color: #cd7f32 !important;
        }
    </style>
@endsection




{{-- @extends('admin.layouts.master')
@section('title', $school->school_name . ' Performance')

@section('content')
    <div class="card shadow border-0">
        <div class="card-header bg-success text-white d-flex justify-content-between">
            <h5>{{ $school->school_name }} — Performance Dashboard</h5>
            <span class="badge bg-light text-success fs-6">{{ $finalMedal }} Medal 🏅</span>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Domain</th>
                        <th>Baseline</th>
                        <th>Saved</th>
                        <th>Achievement (%)</th>
                        <th>Medal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($performance as $domain => $data)
                        <tr>
                            <td>{{ $domain }}</td>
                            <td>{{ number_format($data['baseline']) }}</td>
                            <td>{{ number_format($data['saved']) }}</td>
                            <td>{{ $data['percentage'] }}%</td>
                            <td><span class="badge bg-{{ strtolower($data['medal']) }}">{{ $data['medal'] }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center mt-4">
                <h5>Total Performance: <strong>{{ round($average, 2) }}%</strong></h5>
                <p class="text-muted">Overall Medal Status: <span class="fw-bold text-success">{{ $finalMedal }}</span></p>
            </div>
        </div>
    </div>
@endsection --}}
