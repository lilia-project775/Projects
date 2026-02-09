@extends('student.layouts.master')
@section('title', 'Action')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow rounded-3">
        <div class="card-header custom-bg text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-recycle"></i> Add Action</h5>
            <a href="{{ route('student.actions.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left-circle"></i> View My Performances
            </a>
        </div>

        <div class="card-body px-5 py-4">
            <form action="{{ route('student.actions.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="row g-3">
                    {{-- School (Freezed) --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">School</label>
                        <input type="text" class="form-control" value="{{ $school->school_name ?? 'N/A' }}" readonly>
                        <input type="hidden" name="school_id" value="{{ $school->id ?? '' }}">
                    </div>

                    {{-- Class (Freezed) --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Class</label>
                        <input type="text" class="form-control" value="{{ $class->class_name ?? 'N/A' }}" readonly>
                        <input type="hidden" name="class_id" value="{{ $class->id ?? '' }}">
                    </div>

                    {{-- Section (Freezed) --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Section</label>
                        <input type="text" class="form-control" value="{{ $section->section_name ?? 'N/A' }}" readonly>
                        <input type="hidden" name="section_id" value="{{ $section->id ?? '' }}">
                    </div>

                    {{-- Domain (Circle Buttons) --}}
                    <div class="col-12 mt-4">
                        <label class="form-label fw-semibold d-block">Select Domain <span class="text-danger">*</span></label>
                        <div class="d-flex justify-content-around flex-wrap gap-3">
                            <div class="domain-circle" data-domain="Water">
                                <span class="icon">💧</span>
                                <p class="mt-2 mb-0">Water</p>
                            </div>
                            <div class="domain-circle" data-domain="Energy">
                                <span class="icon">⚡</span>
                                <p class="mt-2 mb-0">Energy</p>
                            </div>
                            <div class="domain-circle" data-domain="Waste">
                                <span class="icon">♻️</span>
                                <p class="mt-2 mb-0">Waste</p>
                            </div>
                        </div>
                        <input type="hidden" name="domain" id="domain" required>
                        <input type="hidden" name="unit" id="unit">
                        @error('domain')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Amount Saved Inputs --}}
                    <div class="col-md-4 mx-auto mt-4 d-none" id="Liters">
                        <label class="form-label fw-semibold">Amount Saved (Liters)</label>
                        <input type="number" name="amount_saved_liters" class="form-control" min="1" placeholder="Enter total water saved">
                    </div>

                    <div class="col-md-4 mt-4 mx-auto  d-none" id="kWh">
                        <label class="form-label fw-semibold">Amount Saved (kWh)</label>
                        <input type="number" name="amount_saved_kwh" class="form-control" min="1" placeholder="Enter total energy saved">
                    </div>

                    <div class="col-md-4 mt-4  mx-auto d-none" id="Kg">
                        <label class="form-label fw-semibold">Amount Saved (Kg)</label>
                        <input type="number" name="amount_saved_kg" class="form-control " min="1" placeholder="Enter total waste reduced">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save"></i> Save Action
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- CSS --}}
<style>
.domain-circle {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: #f8f9fa;
    border: 2px solid #dee2e6;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.domain-circle:hover {
    border-color: #198754;
    background: #e9fce9;
    transform: scale(1.05);
}
.domain-circle.active {
    background: #198754;
    color: white;
    border-color: #198754;
    box-shadow: 0 4px 10px rgba(25,135,84,0.3);
}
.domain-circle .icon {
    font-size: 32px;
}
</style>

{{-- JS --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const circles = document.querySelectorAll(".domain-circle");
    const domainInput = document.getElementById("domain");
    const unitInput = document.getElementById("unit");

    const Liters = document.getElementById("Liters");
    const kWh = document.getElementById("kWh");
    const Kg = document.getElementById("Kg");

    circles.forEach(circle => {
        circle.addEventListener("click", function() {
            circles.forEach(c => c.classList.remove("active"));
            this.classList.add("active");

            const domain = this.getAttribute("data-domain");
            domainInput.value = domain;

            [Liters, kWh, Kg].forEach(div => div.classList.add("d-none"));
            if (domain === "Water") {
                Liters.classList.remove("d-none");
                unitInput.value = "Liters";
            } else if (domain === "Energy") {
                kWh.classList.remove("d-none");
                unitInput.value = "kWh";
            } else if (domain === "Waste") {
                Kg.classList.remove("d-none");
                unitInput.value = "Kg";
            }
        });
    });
});
</script>
@endsection
