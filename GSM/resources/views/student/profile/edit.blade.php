@extends('student.layouts.master')
@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center py-3 px-4">
                    <h5 class="mb-0 fw-semibold"> 
                        <i class="fas fa-user-edit me-2"></i> Edit Profile
                    </h5>
                    <a href="{{ route('student.profile.show') }}" class="btn btn-light btn-sm px-3 py-1 shadow-sm rounded-pill">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
 
                {{-- Body --}}
                <div class="card-body bg-light p-4">
                    <form action="{{ route('student.profile.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-md-6">
                                <label for="student_name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="student_name" id="student_name" 
                                       value="{{ old('student_name', $student->student_name) }}" 
                                       class="form-control rounded-3 @error('student_name') is-invalid @enderror">
                                @error('student_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Phone --}}
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" id="phone" 
                                       value="{{ old('phone', $student->phone) }}" 
                                       class="form-control rounded-3 @error('phone') is-invalid @enderror">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mt-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" id="email" 
                                       value="{{ old('email', $student->email) }}" 
                                       class="form-control rounded-3 @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6 mt-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" id="password" 
                                       value="{{ old('password', $student->password_words) }}" 
                                       class="form-control rounded-3 @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Profile Image --}}
                            <div class="col-md-6 mt-3">
                                <label for="profile_image" class="form-label fw-semibold">Profile Image</label>
                                <input type="file" name="profile_image" id="profile_image" 
                                       class="form-control rounded-3 @error('profile_image') is-invalid @enderror">
                                @error('profile_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if($student->profile_image && file_exists(public_path('uploads/'.$student->profile_image)))
                                    <div class="mt-3 text-center">
                                        <img src="{{ asset('uploads/'.$student->profile_image) }}" 
                                             alt="Profile Image" class="rounded-circle border shadow" 
                                             style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
