@extends('admin.layouts.master')
@section('title', 'Domain Targets')

@section('content')
    <div class="container-fluid">
        <div class="card shadow border-0">
            <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
                <h5>Domain Targets</h5>
                <a href="{{ route('admin.targets.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus"></i> Add
                    New</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>SN</th>
                            <th>Domain</th>
                            <th>Bronze</th>
                            <th>Silver</th>
                            <th>Gold</th>
                            <th>Unit</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($targets as $target)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $target->domain }}</td>
                                <td>{{ $target->bronze_threshold }}%</td>
                                <td>{{ $target->silver_threshold }}%</td>
                                <td>{{ $target->gold_threshold }}%</td>
                                <td>{{ $target->unit }}</td>
                                <td>{{ $target->notes ?? '-' }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.targets.edit', $target->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>Edit
                                    </a>
                                    &nbsp;
                                    <form action="{{ route('admin.targets.destroy', $target->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this domain?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-trash"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection
