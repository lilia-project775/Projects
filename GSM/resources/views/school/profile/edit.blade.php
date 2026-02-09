@extends('school.layouts.master')
@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header custom-bg text-white py-3 px-4" >
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit School Profile</h5>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('school.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">School Name</label>
                            <input type="text" name="school_name" value="{{ old('school_name', $school->school_name) }}" class="form-control" required>
                            @error('school_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Type</label>
                            <input type="text" name="type" value="{{ old('type', $school->type) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Contact Person</label>
                            <input type="text" name="contact_person" value="{{ old('contact_person', $school->contact_person) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" value="{{ old('email', $school->email) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $school->phone) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">District / Region</label>
                            <input type="text" name="district_region" value="{{ old('district_region', $school->district_region) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $school->address) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Logo</label>
                            <input type="file" name="logo" class="form-control">
                             @if($school->logo && file_exists(public_path('uploads/'.$school->logo)))
                                        <a href="{{ asset('uploads/'.$school->logo) }}" target="_blank">
                                            <img src="{{ asset('uploads/'.$school->logo) }}" alt="School Logo"
                                                 class="img-fluid rounded-circle shadow-sm border border-3 border-white mb-3 mt-3"
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        </a>
                                    @else
                                        <img src="{{ asset('img/undraw_profile.svg') }}" alt="Default Logo"
                                             class="img-fluid rounded-circle shadow-sm border border-3 border-white mb-3 mt-3"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Update Profile
                            </button>
                            <a href="{{ route('school.profile.show') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
