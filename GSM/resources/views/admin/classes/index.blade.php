@extends('admin.layouts.master')
@section('title', 'Classes List')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list-ul"></i> All Classes</h5>
            <a href="{{ route('admin.classes.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus-circle"></i> Add New
            </a>
        </div>

        <div class="card-body">
    <div class="row justify-content-end ">
   <div class="col-md-4 ">
      <form method="GET" action="{{ route('admin.classes.index') }}">
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
                <thead class="">
                    <tr>
                        <th>SN</th>
                        <th>School Name</th>
                        <th>Class Name</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $key => $class)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $class->school->school_name ?? 'N/A' }}</td>
                            <td>{{ $class->class_name }}</td>
                            <td>{{ $class->created_at->format('d M, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.classes.show', $class->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil"></i> Edit</a>
                                <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this class?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr> 
                            <td colspan="5" class="text-center text-muted">No classes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="mt-3">
                {{ $classes->appends(['school_id' => request('school_id')])->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
