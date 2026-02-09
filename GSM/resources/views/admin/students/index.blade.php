@extends('admin.layouts.master')
@section('title', 'Students List')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Students</h5>
            <a href="{{ route('admin.students.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus-circle"></i> Add New
            </a>
        </div>
 
        <div class="card-body">
             <div class="row justify-content-end ">
   <div class="col-md-4 ">
      <form method="GET" action="{{ route('admin.students.index') }}">
    <select name="school_id" onchange="this.form.submit()" class="form-control">
        <option value="">--Select School--</option>
        @foreach($allSchools as $school)
            <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                {{ $school->school_name }}
            </option>
        @endforeach
    </select>
</form>

</div> 

</div>
<hr class="shadow mb-4">
            <div class="table-responsive">
            <table class="table table-bordered  align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>SN</th>
                        <th>School</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $key => $student)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                           <td>
                            {{ $student->school->school_name ?? 'N/A' }}
                            </td>
                        

                            <td>{{ $student->class->class_name ?? 'N/A' }}</td>
                            <td>{{ $student->section->section_name ?? 'N/A' }}</td>
                            <td>
                                {{ $student->student_name }}
                           
                            </td>
                            <td>{{ $student->email }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil"></i> Edit</a>
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this student?')"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr> 
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">No students found.</td></tr>
                    @endforelse
                </tbody>
            </table>
</div>
            <div class="mt-3">
               {{ $students->appends(['school_id' => request('school_id')])->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
