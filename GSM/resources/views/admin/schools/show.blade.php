@extends('admin.layouts.master')
@section('title', 'View School Details')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-eye"></i> View School Details</h5>
            <a href="{{ route('admin.schools.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left-circle"></i> Back to List
            </a>
        </div>

        <div class="card-body px-4 py-4">

            <h5 class="text-success fw-bold mb-3"><i class="fas fa-building"></i> School Information</h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th width="25%">School Name</th>
                            <td>{{ $school->school_name }}</td>
                        </tr>
                        <tr>
                            <th>District / Region</th>
                            <td>{{ $school->district_region }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>{{ $school->type }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $school->address }}</td>
                        </tr>
                        <tr>
                            <th>Contact Person</th>
                            <td>{{ $school->contact_person }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $school->email }}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>{{ $school->password_words }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $school->phone }}</td>
                        </tr>
                        <tr>
                            <th>Logo</th>
                            <td>
                                @if ($school->logo)
                                    <img src="{{ asset('uploads/' . $school->logo) }}" width="120" class="rounded shadow-sm border">
                                @else
                                    <span class="text-muted">No logo uploaded</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $school->created_at->format('d M, Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="mt-3 d-flex justify-content-end gap-3">
                <a href="{{ route('admin.schools.edit', $school->id) }}" class="btn btn-primary">
                    <i class="fas fa-pencil"></i> Edit
                </a>
                &nbsp;
                <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this school?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
