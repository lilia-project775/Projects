@extends('admin.layouts.master')
@section('title', 'Edit School')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-pencil-square"></i> Edit School</h5>
            <a href="{{ route('admin.schools.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left-circle"></i> Back to List
            </a>
        </div>

        <div class="card-body px-4 py-4">
            <!--{{-- Show Validation Errors --}}-->
            <!--@if ($errors->any())-->
            <!--    <div class="alert alert-danger">-->
            <!--        <ul class="mb-0">-->
            <!--            @foreach ($errors->all() as $error)-->
            <!--                <li>{{ $error }}</li>-->
            <!--            @endforeach-->
            <!--        </ul>-->
            <!--    </div>-->
            <!--@endif-->
 
            <form action="{{ route('admin.schools.update', $school->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                {{-- ================= SCHOOL DETAILS ================= --}}
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="text-success fw-bold mb-3"><i class="fas fa-info-circle"></i> School Details</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mt-3">School Name <span class="text-danger">*</span></label>
                            <input type="text" name="school_name" value="{{ old('school_name', $school->school_name) }}" class="form-control @error('school_name') is-invalid @enderror" >
                      @error('school_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold mt-3">District / Region <span class="text-danger">*</span></label>
                            <input type="text" name="district_region" value="{{ old('district_region', $school->district_region) }}" class="form-control @error('district_region') is-invalid @enderror" >
                         @error('district_region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold mt-3">Address <span class="text-danger">*</span></label>
                            <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror" >{{ old('address', $school->address) }}</textarea>
                        @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="contact_person" value="{{ old('contact_person', $school->contact_person) }}" class="form-control @error('contact_person') is-invalid @enderror" >
                        @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $school->email) }}" class="form-control @error('email') is-invalid @enderror" >
                             @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $school->phone) }}" class="form-control @error('phone') is-invalid @enderror" >
                             @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Password</label>
                            <input type="text" name="password" value="{{ old('phone', $school->password_words) }}" class="form-control @error('password') is-invalid @enderror" placeholder="Leave blank to keep current password">
                            <small class="text-muted">Only fill if you want to change password</small>
                        @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select form-control @error('type') is-invalid @enderror" >
                                <option value="">-- Select Type --</option>
                                <option value="Public" {{ old('type', $school->type) == 'Public' ? 'selected' : '' }}>Public</option>
                                <option value="Private" {{ old('type', $school->type) == 'Private' ? 'selected' : '' }}>Private</option>
                            </select>
                             @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                      

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Upload School Logo</label>
                            <input type="file" name="logo" class="form-control">
                            @if ($school->logo)
                                <div class="mt-2">
                                    <img src="{{ asset('uploads/' . $school->logo) }}" alt="Logo" width="120" class="rounded shadow-sm">
                                </div>
                            @endif
                            <small class="text-muted">Leave blank to keep existing logo</small>
                        </div>

                    </div>
                </div>

                {{-- ================= BASELINE DATA ================= --}}
           {{--     <!--<div class="border-bottom pb-3 mb-4">-->
                <!--    <h5 class="text-success fw-bold mb-3"><i class="fas fa-bar-chart-line"></i> Monthly Baseline Data</h5>-->

                <!--    <div class="row g-3">-->
                <!--        <div class="col-md-4">-->
                <!--            <label class="form-label fw-semibold mt-3">Water Usage (Liters) <span class="text-danger">*</span></label>-->
                <!--            <input type="number" step="0.01" name="water_usage_liters"-->
                <!--                   value="{{ old('water_usage_liters', $school->baseline->water_usage_liters ?? '') }}"-->
                <!--                   class="form-control" >-->
                <!--        </div>-->

                <!--        <div class="col-md-4">-->
                <!--            <label class="form-label fw-semibold mt-3">Energy Usage (kWh) <span class="text-danger">*</span></label>-->
                <!--            <input type="number" step="0.01" name="energy_usage_kwh"-->
                <!--                   value="{{ old('energy_usage_kwh', $school->baseline->energy_usage_kwh ?? '') }}"-->
                <!--                   class="form-control" >-->
                <!--        </div>-->

                <!--        <div class="col-md-4">-->
                <!--            <label class="form-label fw-semibold mt-3">Waste Generated (Kg) <span class="text-danger">*</span></label>-->
                <!--            <input type="number" step="0.01" name="waste_generated_kg"-->
                <!--                   value="{{ old('waste_generated_kg', $school->baseline->waste_generated_kg ?? '') }}"-->
                <!--                   class="form-control" >-->
                <!--        </div>-->
                <!--    </div> -->
                <!--</div>--> --}}

                {{-- ================= SUBMIT ================= --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-check-circle"></i> Update School
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
