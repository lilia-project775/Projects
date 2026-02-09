@extends('student.layouts.master')
@section('title', 'Student Profile')

@section('content')
<div class="container-fluid px-4 mt-5">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center py-3 px-4">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-user-graduate me-2"></i> My Profile
                    </h5>
                    <div>
                        <a href="{{ route('student.profile.edit', $student->id) }}" 
                           class="btn btn-warning btn-sm me-2 px-3 py-1 shadow-sm rounded-pill">
                            <i class="fas fa-pencil-square me-1"></i> Edit
                        </a>
                        <a href="{{ route('student.dashboard') }}" 
                           class="btn btn-light btn-sm px-3 py-1 shadow-sm rounded-pill">
                            <i class="fas fa-arrow-left-circle me-1"></i> Back
                        </a>
                    </div>
                </div>

                {{-- Body --}}
                <div class="card-body p-4 bg-light">
                    <div class="row g-4 align-items-stretch">

                        {{-- Left: Profile Photo & Basic Info --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100 rounded-4">
                                <div class="card-body text-center py-4">
                                    @if($student->profile_image && file_exists(public_path('uploads/'.$student->profile_image)))
                                        <a href="{{ asset('uploads/'.$student->profile_image) }}" target="_blank">
                                            <img src="{{ asset('uploads/'.$student->profile_image) }}" alt="Student Photo"
                                                 class="img-fluid rounded-circle shadow-sm border border-3 border-white mb-3"
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        </a>
                                    @else
                                        <img src="{{ asset('img/undraw_profile.svg') }}" alt="Default Photo"
                                             class="img-fluid rounded-circle shadow-sm border border-3 border-white mb-3"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @endif

                                    <h4 class="fw-bold mb-1 text-dark">{{ $student->student_name }}</h4>
                                    <p class="text-muted mb-0">{{ $student->email }}</p>
                                    <p class="text-muted small mb-0">Phone: {{ $student->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Academic Details --}}
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm h-100 rounded-4">
                                <div class="card-body p-4">
                                    <table class="table table-bordered align-middle">
                                        <tbody>
                                            <tr>
                                                <th width="35%">School Name</th>
                                                <td>{{ $student->school->school_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Class</th>
                                                <td>{{ $student->class->class_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Section</th>
                                                <td>{{ $student->section->section_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>School Contact</th>
                                                <td>{{ $student->school->phone ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>School Email</th>
                                                <td>{{ $student->school->email ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>School Address</th>
                                                <td>{{ $student->school->address ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Footer --}}
                                <div class="card-footer text-center bg-light border-0 py-3">
                                    <small class="text-muted">
                                        Last Updated: {{ $student->updated_at->format('d M Y, h:i A') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
