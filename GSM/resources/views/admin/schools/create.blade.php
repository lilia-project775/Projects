@extends('admin.layouts.master')
@section('title', 'Add New School')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-building"></i> Add New School</h5>
            <a href="{{ route('admin.schools.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left-circle"></i> Back to List
            </a>
        </div>

        <div class="card-body px-4 py-4">
            
            {{-- how Validation Errors --}}
            <!--@if ($errors->any())-->
            <!--    <div class="alert alert-danger">-->
            <!--        <ul class="mb-0">-->
            <!--            @foreach ($errors->all() as $error)-->
            <!--                <li>{{ $error }}</li>-->
            <!--            @endforeach-->
            <!--        </ul>-->
            <!--    </div>-->
            <!--@endif--> 

            <form action="{{ route('admin.schools.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ================= SCHOOL DETAILS ================= --}}
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="text-success fw-bold mb-3"><i class="fas fa-info-circle"></i> School Details</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mt-3">School Name <span class="text-danger">*</span></label>
                            <input type="text" name="school_name" class="form-control @error('school_name') is-invalid @enderror"
                                placeholder="Enter school name" value="{{ old('school_name') }}" >
                            @error('school_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold mt-3">District / Region <span class="text-danger">*</span></label>
                            <input type="text" name="district_region" class="form-control @error('district_region') is-invalid @enderror"
                                placeholder="Enter district or region" value="{{ old('district_region') }}" >
                            @error('district_region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold mt-3">Address <span class="text-danger">*</span></label>
                            <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror"
                                placeholder="Enter full address" >{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror"
                                placeholder="Name of contact person" value="{{ old('contact_person') }}" >
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter valid email" value="{{ old('email') }}" >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                           
                          
                         <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter Password" >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
    
        
                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                placeholder="Enter contact number" value="{{ old('phone') }}" >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select form-control @error('type') is-invalid @enderror" >
                                <option value="">-- Select Type --</option>
                                <option value="Public" {{ old('type') == 'Public' ? 'selected' : '' }}>Public</option>
                                <option value="Private" {{ old('type') == 'Private' ? 'selected' : '' }}>Private</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                     {{--   <!--<div class="col-md-4">-->
                        <!--    <label class="form-label fw-semibold mt-3">Total Classes <span class="text-danger">*</span></label>-->
                        <!--    <input type="number" name="total_classes" min="1"-->
                        <!--        class="form-control @error('total_classes') is-invalid @enderror"-->
                        <!--        placeholder="e.g., 20" value="{{ old('total_classes') }}" >-->
                        <!--    @error('total_classes')-->
                        <!--        <div class="invalid-feedback">{{ $message }}</div>-->
                        <!--    @enderror-->
                        <!--</div>--> --}}

                  {{--      <!--<div class="col-md-4">-->
                        <!--    <label class="form-label fw-semibold mt-3">Assign Green Captain</label>-->
                        <!--    <select name="green_captain_id" class="form-select form-control @error('green_captain_id') is-invalid @enderror">-->
                        <!--        <option value="">-- Select Captain --</option>-->
                        <!--        @foreach ($captains as $captain)-->
                        <!--            <option value="{{ $captain->id }}" {{ old('green_captain_id') == $captain->id ? 'selected' : '' }}>-->
                        <!--                {{ $captain->name }}-->
                        <!--            </option>-->
                        <!--        @endforeach-->
                        <!--    </select>-->
                        <!--    @error('green_captain_id')-->
                        <!--        <div class="invalid-feedback">{{ $message }}</div>-->
                        <!--    @enderror-->
                        <!--</div>--> --}}

                        <div class="col-md-4">
                            <label class="form-label fw-semibold mt-3">Upload School Logo</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">
                            <small class="text-muted">Accepted formats: JPG, PNG (max 2 MB)</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <!--<div class="col-md-6">-->
                        <!--    <label class="form-label fw-semibold mt-3">Pin on Map</label>-->
                        <!--    <input type="text" name="map_pin" class="form-control @error('map_pin') is-invalid @enderror"-->
                        <!--        placeholder="Paste coordinates or Google Map link" value="{{ old('map_pin') }}">-->
                        <!--    @error('map_pin')-->
                        <!--        <div class="invalid-feedback">{{ $message }}</div>-->
                        <!--    @enderror-->
                        <!--</div>--> --}}
                    </div>
                </div>

                {{-- ================= BASELINE DATA ================= --}}
             {{--   <!--<div class="border-bottom pb-3 mb-4">-->
                <!--    <h5 class="text-success fw-bold mb-3"><i class="fas fa-bar-chart-line"></i> Monthly Baseline Data</h5>-->

                <!--    <div class="row g-3">-->
                <!--        <div class="col-md-4">-->
                <!--            <label class="form-label fw-semibold mt-3">Water Usage (Liters) <span class="text-danger">*</span></label>-->
                <!--            <input type="number" step="0.01" name="water_usage_liters"-->
                <!--                class="form-control @error('water_usage_liters') is-invalid @enderror"-->
                <!--                placeholder="e.g., 30000" value="{{ old('water_usage_liters') }}" >-->
                <!--            @error('water_usage_liters')-->
                <!--                <div class="invalid-feedback">{{ $message }}</div>-->
                <!--            @enderror-->
                <!--        </div>-->

                <!--        <div class="col-md-4">-->
                <!--            <label class="form-label fw-semibold mt-3">Energy Usage (kWh) <span class="text-danger">*</span></label>-->
                <!--            <input type="number" step="0.01" name="energy_usage_kwh"-->
                <!--                class="form-control @error('energy_usage_kwh') is-invalid @enderror"-->
                <!--                placeholder="e.g., 2000" value="{{ old('energy_usage_kwh') }}" >-->
                <!--            @error('energy_usage_kwh')-->
                <!--                <div class="invalid-feedback">{{ $message }}</div>-->
                <!--            @enderror-->
                <!--        </div>-->

                <!--        <div class="col-md-4">-->
                <!--            <label class="form-label fw-semibold mt-3">Waste Generated (Kg) <span class="text-danger">*</span></label>-->
                <!--            <input type="number" step="0.01" name="waste_generated_kg"-->
                <!--                class="form-control @error('waste_generated_kg') is-invalid @enderror"-->
                <!--                placeholder="e.g., 500" value="{{ old('waste_generated_kg') }}" >-->
                <!--            @error('waste_generated_kg')-->
                <!--                <div class="invalid-feedback">{{ $message }}</div>-->
                <!--            @enderror-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div> --> --}}

                {{-- ================= SUBMIT ================= --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save"></i> Save School
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
