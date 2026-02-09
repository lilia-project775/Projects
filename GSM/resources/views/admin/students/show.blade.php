@extends('admin.layouts.master')
@section('title', 'Student Details')

@section('content')
<div class="container-fluid px-0">
    <div class="card shadow border-0 rounded-3">
        <div class="card-header custom-bg text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Student Details</h5>
            <a href="{{ route('admin.students.index') }}" class="btn btn-light btn-sm text-dark">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered  mb-0">
                <tbody>
                    <tr>
                        <th width="25%">School</th>
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
                        <th>Student Name</th>
                        <td>{{ $student->student_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $student->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $student->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Password (Plain)</th>
                        <td>{{ $student->password_words }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $student->created_at->format('d M, Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
