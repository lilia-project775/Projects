@extends('school.layouts.master')
@section('title', 'All Students')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Students</h5>
            <a href="{{ route('school.students.create') }}" class="btn btn-light btn-sm">
                <i class="fa fa-plus"></i> Add Student
            </a>
        </div>
        <div class="card-body">
            
           <div class="row justify-content-end mb-3">
    <div class="col-md-4">
      <form action="{{ route('school.students.index') }}" method="GET">
    <div class="input-group">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search Student">
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
                <thead class="">
                    <tr>
                        <th>SN</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                          
                            <td class="text-nowrap">
    {{ $student->student_name }}

    @if($student->is_captain)
        {{-- Show badge --}}
        <span class="badge bg-success text-light">Captain</span><br>

        {{-- Change Captain button --}}
        <a href="{{ route('school.captain.edit', $student->id) }}" class="btn btn-sm btn-primary mt-2">
            <i class="fas fa-edit"></i> Change Captain
        </a>

       <form action="{{ route('school.captain.remove', $student->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE') 
    <button type="submit" class="btn btn-sm btn-danger mt-2"
        onclick="return confirm('Are you sure you want to remove this captain?')">
        <i class="fas fa-user-times"></i> Remove
    </button>
</form>
 
    @else
        {{-- Assign Captain button --}}
       {{--
       <!--<a href="{{ route('school.captain.edit', $student->id) }}" class="btn btn-sm btn-outline-secondary mt-2">-->
        <!--    <i class="fas fa-user-check"></i> Assign Captain-->
        <!--</a>-->
        --}}
    @endif
</td>

                            
                            
                            <td>{{ $student->class->class_name ?? '-' }}</td>
                            <td>{{ $student->section->section_name ?? '-' }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('school.students.show', $student->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                <a href="{{ route('school.students.edit', $student->id) }}" class="btn btn-warning btn-sm"> <i class="fas fa-pencil-alt"></i> Edit</a>
                                <form action="{{ route('school.students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                                   <a href="{{ route('school.student.performance.show', $student->id) }}"
                                        class="btn btn-sm btn-success"> 
                                         <i class="fas fa-chart-line"></i> View Performance
                                    </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="mt-1">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
