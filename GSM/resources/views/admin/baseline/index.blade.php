@extends('admin.layouts.master')
@section('title', 'Baseline List')

@section('content')
<div class="container-fluid px-0">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Baseline Data List</h5>
            <a href="{{ route('admin.baseline.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Add New
            </a>
        </div>
        <div class="card-body">
             <!--filter-->
          <div class="row justify-content-end mb-3">
    <div class="col-md-4">
      <form action="{{ route('admin.baseline.index') }}" method="GET">
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

            <div class="responsiv table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="">
                    <tr>
                        <th>SN</th>
                        <th>School Name</th>
                        <th>Water Usage (L)</th>
                        <th>Energy Usage (kWh)</th>
                        <th>Waste (Kg)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($baselines as $baseline)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $baseline->school->school_name ?? 'N/A' }}</td>
                            <td>{{ $baseline->water_usage_liters }}</td>
                            <td>{{ $baseline->energy_usage_kwh }}</td>
                            <td>{{ $baseline->waste_generated_kg }}</td>
                            <td>
                                <a href="{{ route('admin.baseline.show', $baseline->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>View
                                    </a>
                                   <a href="{{ route('admin.baseline.edit', $baseline->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.baseline.destroy', $baseline->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                       <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No data available</td></tr>
                    @endforelse
                </tbody>
            </table>
             
              <div class="mt-3">
                {{ $baselines->links() }}
            </div>
            
            </div>
        </div>
    </div>
</div>
@endsection
