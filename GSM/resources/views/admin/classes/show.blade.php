@extends('admin.layouts.master')
@section('title', 'View Class Details')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-eye"></i> View Class Details</h5>
            <a href="{{ route('admin.classes.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left-circle"></i> Back to List
            </a>
        </div>

        <div class="card-body px-4 py-4">

            <h5 class="text-success fw-bold mb-3"><i class="fas fa-journal-text"></i> Class Information</h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th width="25%">School Name</th>
                            <td>{{ $class->school->school_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Class Name</th>
                            <td>{{ $class->class_name }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $class->created_at->format('d M, Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="mt-3 d-flex justify-content-end gap-3">
                <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-primary">
                    <i class="fas fa-pencil"></i> Edit
                </a>
                &nbsp;
                <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this class?');">
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
