    @extends('admin.layouts.master')
    @section('title', 'Schools List')

    @section('content')
        <div class="card shadow-sm">
            <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Schools</h5>
                <a href="{{ route('admin.schools.create') }}" class="btn btn-light btn-sm">+ Add School</a>
            </div> 
            <div class="card-body">
                
                    <!--filter-->
          <div class="row justify-content-end mb-3">
    <div class="col-md-4">
      <form action="{{ route('admin.schools.index') }}" method="GET">
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



                <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>School Name</th>
                            <th>Type</th>
                            <th>District</th>
                            <!--<th>Green Captain</th>-->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schools as $school)
                            <tr>
                                <td>{{ $school->id }}</td>
                                <td>{{ $school->school_name }}</td>
                                <td>{{ $school->type }}</td>
                                <td>{{ $school->district_region }}</td>
                                <!--<td>{{ optional($school->greenCaptain)->name ?? '—' }}</td>-->
                                <td>
                                    {{-- View Button --}}
                                    <a href="{{ route('admin.schools.show', $school->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.schools.edit', $school->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this school?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>

                                    <!-- ✅ View Performance Button -->
                                    <a href="{{ route('admin.performance.show', $school->id) }}"
                                        class="btn btn-sm btn-success">
                                        <i class="bi bi-bar-chart-line"></i> View Performance
                                    </a>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                 <div class="mt-1">
                    {{$schools->links()}}
                </div>
            </div>
        </div>
    @endsection
