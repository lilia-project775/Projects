@extends('school.layouts.master')
@section('title', 'View Student')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white">
            <h5>Student Details</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Student Name</th>
                    <td>{{ $student->student_name }}</td>
                </tr>
                <tr>
                    <th>School</th>
                    <td>{{ $student->school->school_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Class</th>
                    <td>{{ $student->class->class_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Section</th>
                    <td>{{ $student->section->section_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $student->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $student->phone }}</td>
                </tr>
                <tr>
                    <th>Password (Plain)</th>
                    <td>{{ $student->password_words }}</td>
                </tr>
            </table>

            <a href="{{ route('school.students.edit', $student->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('school.students.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
