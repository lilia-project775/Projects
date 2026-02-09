@extends('school.layouts.master')
@section('title', 'All Classes')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5>All Classes</h5>
            <a href="{{ route('school.class.create') }}" class="btn btn-light btn-sm">+ Add New Class</a>
        </div>
        <div class="card-body">
      
      <!--filter-->
          <div class="row justify-content-end mb-3">
    <div class="col-md-4">
      <form action="{{ route('school.class.index') }}" method="GET">
    <div class="input-group">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search Class">
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

            @if($classes->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered  align-middle">
                    <thead class="">
                        <tr> 
                            <th>SN</th>
                            <th>Class Name</th>
                            <th>Actions</th>
                        </tr> 
                    </thead>
                    <tbody>
                        @foreach ($classes as $index => $class)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $class->class_name }}</td>
                                <td>
                                    <a href="{{ route('school.class.show', $class->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                    <a href="{{ route('school.class.edit', $class->id) }}" class="btn btn-warning btn-sm"> <i class="fas fa-pencil-alt"></i> Edit</a>
                                    <form action="{{ route('school.class.destroy', $class->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this class?')"><i class="fas fa-trash-alt"></i> Delete</button>
                                    </form>
                                      <a href="{{ route('school.performance.show', $class->id) }}"
                                        class="btn btn-sm btn-success">
                                          <i class="fas fa-chart-line"></i> View Performance
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                
                <div class="mt-1">
                    {{$classes->links()}}
                </div>
            @else
                <div class="text-center text-muted">No classes found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
