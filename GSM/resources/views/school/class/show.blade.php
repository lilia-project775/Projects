@extends('school.layouts.master')
@section('title', 'View Class Details')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Class Details</h5>
            <div>
                <a href="{{ route('school.class.edit', $class->id) }}" class="btn btn-warning btn-sm me-2">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="{{ route('school.class.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>
        </div> 

        <div class="card-body">
            <table class="table table-bordered align-middle mb-0">
                <tbody>
                    <tr>
                        <th width="30%">School Name</th>
                        <td>{{ Auth::user()->school->school_name }}</td>
                    </tr>
                    <tr>
                        <th>Class Name</th>
                        <td>{{ $class->class_name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
