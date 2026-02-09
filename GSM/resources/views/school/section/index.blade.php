@extends('school.layouts.master')
@section('title', 'All Sections')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5>All Sections</h5>
            <a href="{{ route('school.section.create') }}" class="btn btn-light btn-sm">+ Add New Section</a>
        </div>
        <div class="card-body">
        
         <div class="row justify-content-end mb-3">
    <div class="col-md-4">
      <form action="{{ route('school.section.index') }}" method="GET">
    <div class="input-group">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search Section">
      <button type="submit" class="btn"
    style="background-color: green; color: #fff; transition: background-color 0.3s ease; border-bottom-left-radius: 0; border-top-left-radius: 0;"
    onmouseover="this.style.backgroundColor='#218838';"
    onmouseout="this.style.backgroundColor='green';">
    Filter
</button>


    </div>
</form> 

    </div>
</div>


           <div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead>
            <tr> 
                <th>SN</th>
                <th>Class</th>
                <th>Section</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sections as $index => $section)
                <tr>
                    <td>{{ $sections->firstItem() + $index }}</td> {{-- Pagination-friendly SN --}}
                    <td>{{ $section->class->class_name ?? 'N/A' }}</td>
                    <td>{{ $section->section_name }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('school.section.show', $section->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>

                        <a href="{{ route('school.section.edit', $section->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>

                        <form action="{{ route('school.section.destroy', $section->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this section?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('school.section.performance.show', $section->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-chart-line"></i> View Performance
                        </a>

                        @php
                            $captain = $section->students->where('is_captain', 1)->first();
                        @endphp

                        @if($captain)
                            <a href="{{ route('school.captain.edit', $captain->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Change Captain
                            </a>

                            <form action="{{ route('school.captain.remove', $captain->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to remove this captain?')">
                                    <i class="fas fa-user-times"></i> Remove
                                </button>
                            </form>

                            <span class="badge bg-success text-light">Captain</span>
                            <span class="badge bg-primary text-light">{{ $captain->student_name }}</span><br>
                        @else
                            <span class="text-muted">No Captain Assigned</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No sections found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination Links --}}
<div class="mt-3">
    {{ $sections->links() }}
</div>

        </div>
    </div>
</div>
@endsection
