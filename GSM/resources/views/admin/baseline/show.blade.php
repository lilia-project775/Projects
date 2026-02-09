@extends('admin.layouts.master')
@section('title', 'View Baseline Data')

@section('content')
<div class="container-fluid px-0">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-bar-chart-line me-2"></i> Monthly Baseline Details
            </h5>
            <a href="{{ route('admin.baseline.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left-circle"></i> Back to List
            </a>
        </div>

        <div class="card-body px-4 py-4">

            {{-- ========== SCHOOL INFORMATION ========== --}}
            <h5 class="text-success fw-bold mb-3">
                <i class="fas fa-building me-2"></i> School Information
            </h5>

            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th width="25%">School Name</th>
                            <td>{{ $baseline->school->school_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>School ID</th>
                            <td>{{ $baseline->school_id }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- ========== BASELINE DATA IN CARDS ========== --}}
            <h5 class="text-success fw-bold mb-3">
                <i class="fas fa-graph-up-arrow me-2"></i> Baseline Metrics
            </h5>

            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-start border-primary border-4">
                        <div class="card-body">
                            <i class="fas fa-droplet-half text-primary fs-2 mb-2"></i>
                            <label class="fw-semibold d-block">Water Usage</label>
                            <h4 class="text-primary mb-0">{{ number_format($baseline->water_usage_liters, 2) }} L</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-start border-warning border-4">
                        <div class="card-body">
                            <i class="fas fa-lightning-charge text-warning fs-2 mb-2"></i>
                            <label class="fw-semibold d-block">Energy Usage</label>
                            <h4 class="text-warning mb-0">{{ number_format($baseline->energy_usage_kwh, 2) }} kWh</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-start border-danger border-4">
                        <div class="card-body">
                            <i class="fas fa-trash3 text-danger fs-2 mb-2"></i>
                            <label class="fw-semibold d-block">Waste Generated</label>
                            <h4 class="text-danger mb-0">{{ number_format($baseline->waste_generated_kg, 2) }} Kg</h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========== RECORD DETAILS ========== --}}
            <h5 class="text-success fw-bold mt-4 mb-3">
                <i class="fas fa-clock-history me-2"></i> Record Information
            </h5>

            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th width="25%">Created At</th>
                            <td>{{ $baseline->created_at->format('d M, Y h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr> 

            {{-- ========== ACTION BUTTONS ========== --}}
            <div class="text-end mt-3">
                <a href="{{ route('admin.baseline.edit', $baseline->id) }}" class="btn btn-primary">
                    <i class="fas fa-pencil"></i> Edit
                </a>

                <form action="{{ route('admin.baseline.destroy', $baseline->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this record?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
