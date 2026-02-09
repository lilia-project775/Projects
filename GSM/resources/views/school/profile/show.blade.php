@extends('school.layouts.master')
@section('title', 'School Profile')

@section('content')
<div class="container-fluid px-4 mt-5">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center py-3 px-4">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-school me-2"></i> School Profile
                    </h5>
                    <div>
                        <a href="{{ route('school.profile.edit', $school->id) }}" class="btn btn-warning btn-sm me-2 px-3 py-1 shadow-sm rounded-pill">
                            <i class="fas fa-pencil-square me-1"></i> Edit
                        </a>
                        <a href="{{ route('school.dashboard') }}" class="btn btn-light btn-sm px-3 py-1 shadow-sm rounded-pill">
                            <i class="fas fa-arrow-left-circle me-1"></i> Back
                        </a>
                    </div>
                </div>

                {{-- Body --}}
                <div class="card-body p-4 bg-light">
                    <div class="row g-4 align-items-stretch">

                        {{-- Left: Logo and Basic Info --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100 rounded-4">
                                <div class="card-body text-center py-4">
                                    @if($school->logo && file_exists(public_path('uploads/'.$school->logo)))
                                        <a href="{{ asset('uploads/'.$school->logo) }}" target="_blank">
                                            <img src="{{ asset('uploads/'.$school->logo) }}" alt="School Logo"
                                                 class="img-fluid rounded-circle shadow-sm border border-3 border-white mb-3"
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        </a>
                                    @else
                                        <img src="{{ asset('img/undraw_profile.svg') }}" alt="Default Logo"
                                             class="img-fluid rounded-circle shadow-sm border border-3 border-white mb-3"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @endif

                                    <h4 class="fw-bold mb-0 text-dark">{{ $school->school_name }}</h4>
                                    <p class="text-muted mb-0">{{ $school->type ?? 'School Type N/A' }}</p>
                                </div>
                            </div>
                        </div> 

                        {{-- Right: Details --}}
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm h-100 rounded-4">
                                <div class="card-body p-4">
                                    <table class="table table-border align-middle">
                                        <tbody>
                                            <tr>
                                                <th class="text-secondary" width="30%"><i class="fas fa-person-fill me-2 text-primary"></i> Contact Person:</th>
                                                <td class="fw-medium">{{ $school->contact_person ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-secondary"><i class="fas fa-envelope-fill me-2 text-primary"></i> Email:</th>
                                                <td class="fw-medium">{{ $school->email ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-secondary"><i class="fas fa-telephone-fill me-2 text-primary"></i> Phone:</th>
                                                <td class="fw-medium">{{ $school->phone ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-secondary"><i class="fas fa-geo-alt-fill me-2 text-primary"></i> District / Region:</th>
                                                <td class="fw-medium">{{ $school->district_region ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-secondary"><i class="fas fa-house-fill me-2 text-primary"></i> Address:</th>
                                                <td class="fw-medium">{{ $school->address ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Footer --}}
                                <div class="card-footer text-center bg-light border-0 py-3">
                                    <small class="text-muted">
                                        <i class="fas fa-clock-history me-1"></i>
                                        Last Updated: {{ $school->updated_at->format('d M Y, h:i A') }}
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
