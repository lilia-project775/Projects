@extends('admin.layouts.master')
@section('title', 'Add Domain Target')

@section('content')
    <div class="container">
        <div class="card shadow border-0">
            <div class="card-header custom-bg text-white">
                <h5>Add New Domain Target</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.targets.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Domain</label>
                        <select name="domain" class="form-select form-control" required>
                            <option value="">Select Domain</option>
                            <option value="Water">Water</option>
                            <option value="Energy">Energy</option>
                            <option value="Waste">Circular Waste</option>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Bronze (%)</label>
                            <input type="number" name="bronze_threshold" class="form-control" value="0" step="0.01"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Silver (%)</label>
                            <input type="number" name="silver_threshold" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gold (%)</label>
                            <input type="number" name="gold_threshold" class="form-control" step="0.01" required>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Unit (e.g. Liters, kWh, Kg)</label>
                        <input type="text" name="unit" class="form-control" required>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
