@extends('student.layouts.master')
@section('title', 'Action Details')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-eye"></i> Performance Details</h5>
            <a href="{{ route('student.actions.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left-circle"></i> Back to Performances
            </a>
        </div>
 
        <div class="card-body px-5 py-4">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th width="30%">School</th>
                            <td>{{ $action->school->school_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Class</th>
                            <td>{{ $action->class->class_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Section</th>
                            <td>{{ $action->section->section_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Domain</th>
                            <td>
                                @if ($action->domain === 'Water')
                                    💧 Water
                                @elseif($action->domain === 'Energy')
                                    ⚡ Energy
                                @else
                                    ♻️ Waste
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Unit</th>
                            <td>{{ $action->unit }}</td>
                        </tr>
                        <tr>
                            <th>Amount Saved</th>
                            <td>{{ number_format($action->amount_saved, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Date Logged</th>
                            <td>{{ $action->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('student.actions.edit', $action->id) }}" class="btn btn-primary">
                    <i class="fas fa-pencil-square"></i> Edit Action
                </a>
                <form action="{{ route('student.actions.destroy', $action->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this action?');">
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

{{-- Optional CSS Enhancement --}}

@endsection
