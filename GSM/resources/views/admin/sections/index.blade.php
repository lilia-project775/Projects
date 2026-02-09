@extends('admin.layouts.master')
@section('title', 'Sections List')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list-ul"></i> All Sections</h5>
            <a href="{{ route('admin.section.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus-circle"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
  
    <div class="row justify-content-end ">
   <div class="col-md-4 ">
      <form method="GET" action="{{ route('admin.section.index') }}">
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
   
            <table class="table table-bordered align-middle">
                <thead class="">
                    <tr> 
                        <th>SN</th>
                        <th>School Name</th>
                        <th>Class Name</th>
                        <th>Section Name</th> 
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sections as $key => $section)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $section->school->school_name ?? 'N/A' }}</td>
                            <td>{{ $section->class->class_name ?? 'N/A' }}</td>
                            <td><span class="fw-bold">{{ $section->section_name }}</span></td>
                            <td>{{ $section->created_at->format('d M, Y') }}</td>
                           <td class="text-center">

    {{-- View Button --}}
    <a href="{{ route('admin.section.show', $section->id) }}" 
       class="btn btn-info btn-sm text-white" 
       title="View Details">
        <i class="fas fa-eye"></i> View
    </a>

    {{-- Edit Button --}}
    <a href="{{ route('admin.section.edit', $section->id) }}" 
       class="btn btn-warning btn-sm text-white" 
       title="Edit Section">
        <i class="fas fa-edit"></i> Edit
    </a>

    {{-- Delete Button --}}
    <form action="{{ route('admin.section.destroy', $section->id) }}" 
          method="POST" 
          class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="btn btn-danger btn-sm" 
                title="Delete Section"
                onclick="return confirm('Are you sure you want to delete this section?')">
            <i class="fas fa-trash"></i> Delete
        </button>
    </form>

</td>

                        </tr>
                        
                                            @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No sections found.</td>
                        </tr>
                    @endforelse
                   
                </tbody>
            </table>
            </div>
                 <div class="mt-3">
             
                {{ $sections->appends(['school_id' => request('school_id')])->links() }}

                </div>
        </div>
    </div>
</div>
@endsection
