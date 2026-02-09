@extends('school.layouts.master')
@section('title', $school->school_name . ' - Overall School Performance')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $school->school_name }} — Overall Performance</h5>
            <span class="badge bg-light text-primary fs-6">{{ $finalMedal }} Medal 🏅</span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="">
                        <tr>
                            <th>SN</th>
                            <th>Class Name</th>
                            <th>School Target Contribution</th>
                            <th>Medal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($school->classes as $index => $class)
                            @php
                                $medal = \App\Models\Medal::where('class_id', $class->id)->first();
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $class->class_name }}</td>
                                <td>{{ $medal->performance_percentage ?? '0.00' }}%</td>
                                <td>
                                    @if ($medal && $medal->medal_type === 'Gold')
                                        <span class="badge bg-warning text-dark fw-semibold">🥇 Gold</span>
                                    @elseif ($medal && $medal->medal_type === 'Silver')
                                        <span class="badge bg-secondary text-white fw-semibold">🥈 Silver</span>
                                    @else
                                        <span class="badge bg-bronze text-white fw-semibold">🥉 Bronze</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted">No classes found for this school.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <h5 class="text-muted mb-2">Overall School Performance</h5>
                <p class="fs-5 mb-1">
                    <strong>Average Performance:</strong> {{ round($average, 2) }}%
                </p>
                <p class="fs-5 mb-0">
                    <strong>Final Medal:</strong>
                    <span class="fw-bold text-primary">{{ $finalMedal }} 🏅</span>
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
