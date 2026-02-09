@extends('student.layouts.master')
@section('title', 'Actions')

@section('content')
    <div class="container-fluid px-0">
        <div class="card border-0 shadow-lg rounded-3">
            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list-check"></i> My Performances</h5>
                <a href="{{ route('student.actions.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus-circle"></i> Add New Action
                </a>
            </div>

            <div class="card-body p-4">


                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class=" text-center">
                            <tr>
                                <th>SN</th>
                                <th>Domain</th>
                                <th>Unit</th>
                                <th>Performance (%)</th>
                                <th>Date Logged</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @if ($actions->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="fas fa-info-circle fa-lg mb-2 text-secondary"></i><br>
                                        No actions logged yet.
                                    </td>
                                </tr>
                            @else
                                @foreach ($actions as $index => $action)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($action->domain === 'Water')
                                                💧 Water
                                            @elseif($action->domain === 'Energy')
                                                ⚡ Energy
                                            @else
                                                ♻️ Waste
                                            @endif
                                        </td>
                                        <td>{{ $action->unit }}</td>
                                        <td>{{ number_format($action->amount_saved, 2) }}</td>
                                        <td>{{ $action->created_at->format('d M Y') }}</td>
                                        <td>
                                            
                                            <a href="{{ route('student.actions.show', $action->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        
                                            <a href="{{ route('student.actions.edit', $action->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-pencil-square"></i> Edit
                                            </a>
 
                                            <form action="{{ route('student.actions.destroy', $action->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this action?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
