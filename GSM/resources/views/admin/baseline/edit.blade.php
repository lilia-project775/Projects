@extends('admin.layouts.master')
@section('title', 'Edit Baseline Data')

@section('content')
<div class="container-fluid px-0">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header custom-bg text-white">
            <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Monthly Baseline</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.baseline.update', $baseline->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="school_id">Select School</label>
                    <select name="school_id" class="form-control">
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}" {{ $baseline->school_id == $school->id ? 'selected' : '' }}>
                                {{ $school->school_name }}
                            </option>
                        @endforeach
                    </select>
                     @error('school_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Water Usage (Liters)</label>
                    <input type="number" name="water_usage_liters" class="form-control @error('water_usage_liters') is-invalid @enderror" value="{{ $baseline->water_usage_liters }}">
              @error('water_usage_liters')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Energy Usage (kWh)</label>
                    <input type="number" name="energy_usage_kwh" class="form-control @error('energy_usage_kwh') is-invalid @enderror" value="{{ $baseline->energy_usage_kwh }}">
                @error('energy_usage_kwh')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Waste Generated (Kg)</label>
                    <input type="number" name="waste_generated_kg" class="form-control @error('waste_generated_kg') is-invalid @enderror" value="{{ $baseline->waste_generated_kg }}">
                @error('waste_generated_kg')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning text-white">Update</button>
                <a href="{{ route('admin.baseline.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
