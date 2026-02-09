@extends('admin.layouts.master')
@section('title', 'View School Details')

@section('content')
    <div class="container-fluid px-0">
        <div class="card border-0 shadow-lg rounded-3">
            <div class="card-header custom-bg text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-eye"></i> View School Details</h5>
                <a href="{{ route('admin.schools.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left-circle"></i> Back to List
                </a>
            </div>

            <div class="card-body px-4 py-4">
                {{-- ========== SCHOOL INFO ========== --}}
                <h5 class="text-success fw-bold mb-3"><i class="bi bi-building"></i> School Information</h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">School Name:</label>
                        <div>{{ $school->school_name }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">District / Region:</label>
                        <div>{{ $school->district_region }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Type:</label>
                        <div>{{ $school->type }}</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Address:</label>
                        <div>{{ $school->address }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Contact Person:</label>
                        <div>{{ $school->contact_person }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Email:</label>
                        <div>{{ $school->email }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Phone:</label>
                        <div>{{ $school->phone }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Total Classes:</label>
                        <div>{{ $school->total_classes }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Green Captain:</label>
                        <div>{{ $school->greenCaptain->name ?? 'Not Assigned' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Map Pin:</label>
                        <div>{{ $school->map_pin ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <label class="form-label fw-semibold">Logo:</label><br>
                        @if ($school->logo)
                            <img src="{{ asset('uploads/' . $school->logo) }}" width="120"
                                class="rounded shadow-sm border">
                        @else
                            <span class="text-muted">No logo uploaded</span>
                        @endif
                    </div>
                </div>

                {{-- ========== BASELINE DATA ========== --}}
                <h5 class="text-success fw-bold mt-4 mb-3"><i class="bi bi-bar-chart-line"></i> Monthly Baseline Data</h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Water Usage (Liters):</label>
                        <div>{{ number_format($school->baseline->water_usage_liters ?? 0, 2) }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Energy Usage (kWh):</label>
                        <div>{{ number_format($school->baseline->energy_usage_kwh ?? 0, 2) }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Waste Generated (Kg):</label>
                        <div>{{ number_format($school->baseline->waste_generated_kg ?? 0, 2) }}</div>
                    </div>
                </div>
                <hr>
                {{-- ========== ACTION BUTTONS ========== --}}
                <div class="mt-4 d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.schools.edit', $school->id) }}" class="btn btn-primary ">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    &nbsp;
                    <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this school?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger ">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
