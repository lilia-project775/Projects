@extends('student.layouts.master')
@section('title', 'Actions')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list-check"></i> My Performances</h5>
            <a href="{{ route('student.actions.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus-circle"></i> Add New Action
            </a>
        </div> 
 
        <div class="card-body p-4">
            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
               
                <li class="nav-item " role="presentation">
                    <button class="nav-link {{ $activeTab == 'water' ? 'active' : '' }}" id="water-tab"
                        data-bs-toggle="tab" data-bs-target="#water" type="button" role="tab"
                        aria-controls="water" aria-selected="{{ $activeTab == 'water' ? 'true' : 'false' }}">
                        Water
                    </button>
                </li>
                 
                <li class="nav-item mx-2" role="presentation">
                    <button class="nav-link {{ $activeTab == 'energy' ? 'active' : '' }}" id="energy-tab"
                        data-bs-toggle="tab" data-bs-target="#energy" type="button" role="tab"
                        aria-controls="energy" aria-selected="{{ $activeTab == 'energy' ? 'true' : 'false' }}">
                        Energy
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'waste' ? 'active' : '' }}" id="waste-tab"
                        data-bs-toggle="tab" data-bs-target="#waste" type="button" role="tab"
                        aria-controls="waste" aria-selected="{{ $activeTab == 'waste' ? 'true' : 'false' }}">
                        Waste
                    </button>
                </li>
            </ul>

            {{-- Tab Content --}}
            <div class="tab-content" id="myTabContent">

                {{-- Water Tab --}}
              
                <div class="tab-pane fade {{ $activeTab == 'water' ? 'show active' : '' }}" id="water" role="tabpanel" aria-labelledby="water-tab">
                  <!--filter water-->
                <div class="row justify-content-end mb-3">
    <div class="col-md-6">
        <form action="{{ route('student.actions.index') }}" method="GET" class="row g-2 align-items-end">
             <input type="hidden" name="tab" value="water">
            <div class="col-auto">
                <label for="water_from_date" class="form-label">From:</label>
                <input type="date" name="water_from_date" id="from_date" value="{{ request('water_from_date') }}" class="form-control">
            </div>

            <div class="col-auto">
                <label for="water_to_date" class="form-label">To:</label>
                <input type="date" name="water_to_date" id="water_to_date" value="{{ request('water_to_date') }}" class="form-control">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-success mt-1">
                    Filter
                </button>
            </div>
        </form>
    </div>
</div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Domain</th>
                                    <th>Performance (%)</th>
                                    <th>Date Logged</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($waterActions->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-muted py-5">
                                            <i class="fas fa-info-circle fa-lg mb-2 text-secondary"></i><br>
                                            No actions logged yet.
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($waterActions as $index => $waterAction)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>💧 Water</td>
                                            <td>{{ number_format($waterAction->amount_saved, 2) }} {{ $waterAction->unit }}</td>
                                            <td>{{ $waterAction->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('student.actions.show', $waterAction->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> View</a>
                                                <a href="{{ route('student.actions.edit', $waterAction->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-square"></i> Edit</a>
                                                <form action="{{ route('student.actions.destroy', $waterAction->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this action?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                      <div class="mt-1">
                        <b>Total Water Performances: </b> <span>{{$waterTotal ?? '0.00'}} Liters</span>
                    </div>
                    <div class="mt-3">
                        {{ $waterActions->appends(['tab' => 'water'])->links() }}
                    </div>
                </div>

                {{-- Energy Tab --}}
                <div class="tab-pane fade {{ $activeTab == 'energy' ? 'show active' : '' }}" id="energy" role="tabpanel" aria-labelledby="energy-tab">
                     <!--filter Energy-->
                <div class="row justify-content-end mb-3">
                    
    <div class="col-md-6">
        <form action="{{ route('student.actions.index') }}" method="GET" class="row g-2 align-items-end">
         <input type="hidden" name="tab" value="energy">
            <div class="col-auto">
                <label for="energy_from_date" class="form-label">From:</label>
                <input type="date" name="energy_from_date" id="from_date" value="{{ request('energy_from_date') }}" class="form-control">
            </div>

            <div class="col-auto">
                <label for="energy_to_date" class="form-label">To:</label>
                <input type="date" name="energy_to_date" id="energy_to_date" value="{{ request('energy_to_date') }}" class="form-control">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-success mt-1">
                    Filter
                </button>
            </div>
        </form>
    </div>
</div>
                   
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Domain</th>
                                    <th>Performance (%)</th>
                                    <th>Date Logged</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($energyActions->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-muted py-5">
                                            <i class="fas fa-info-circle fa-lg mb-2 text-secondary"></i><br>
                                            No actions logged yet.
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($energyActions as $index => $energyAction)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>⚡ Energy</td>
                                            <td>{{ number_format($energyAction->amount_saved, 2) }} {{ $energyAction->unit }}</td>
                                            <td>{{ $energyAction->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('student.actions.show', $energyAction->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> View</a>
                                                <a href="{{ route('student.actions.edit', $energyAction->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-square"></i> Edit</a>
                                                <form action="{{ route('student.actions.destroy', $energyAction->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this action?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                      <div class="mt-1">
                        <b>Total Energy Performances: </b> <span>{{$energyTotal ?? '0.00'}} kWh</span>
                    </div>
                    <div class="mt-3">
                        {{ $energyActions->appends(['tab' => 'energy'])->links() }}
                    </div>
                </div>

                {{-- Waste Tab --}}
                <div class="tab-pane fade {{ $activeTab == 'waste' ? 'show active' : '' }}" id="waste" role="tabpanel" aria-labelledby="waste-tab">
                     <!--filter Waste-->
                <div class="row justify-content-end mb-3">
    <div class="col-md-6">
        <form action="{{ route('student.actions.index') }}" method="GET" class="row g-2 align-items-end">
               <input type="hidden" name="tab" value="waste">
            <div class="col-auto">
                <label for="waste_from_date" class="form-label">From:</label>
                <input type="date" name="waste_from_date" id="waste_from_date" value="{{ request('waste_from_date') }}" class="form-control">
            </div>

            <div class="col-auto">
                <label for="waste_to_date" class="form-label">To:</label>
                <input type="date" name="waste_to_date" id="waste_to_date" value="{{ request('waste_to_date') }}" class="form-control">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-success mt-1">
                    Filter
                </button>
            </div>
        </form>
    </div>
</div>
                   
                   
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Domain</th>
                                    <th>Performance (%)</th>
                                    <th>Date Logged</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($wasteActions->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-muted py-5">
                                            <i class="fas fa-info-circle fa-lg mb-2 text-secondary"></i><br>
                                            No actions logged yet.
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($wasteActions as $index => $wasteAction)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>♻️ Waste</td>
                                            <td>{{ number_format($wasteAction->amount_saved, 2) }} {{ $wasteAction->unit }}</td>
                                            <td>{{ $wasteAction->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('student.actions.show', $wasteAction->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> View</a>
                                                <a href="{{ route('student.actions.edit', $wasteAction->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-square"></i> Edit</a>
                                                <form action="{{ route('student.actions.destroy', $wasteAction->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this action?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-1">
                        <b>Total Waste Performances: </b> <span>{{$wasteTotal ?? '0.00'}} Kg</span>
                    </div>
                    <div class="mt-3">
                        {{ $wasteActions->appends(['tab' => 'waste'])->links() }}
                    </div>
                </div>

            </div> {{-- end tab-content --}}
        </div> {{-- end card-body --}}
    </div> {{-- end card --}}
</div> {{-- end container --}}

{{-- Script for keeping correct tab active --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab') || 'water';

    // Activate correct tab after reload
    const activeTabButton = document.querySelector(`#${activeTab}-tab`);
    if (activeTabButton) {
        new bootstrap.Tab(activeTabButton).show();
    }

    // Update tab query param when tab is changed
    document.querySelectorAll('#myTab button[data-bs-toggle="tab"]').forEach(button => {
        button.addEventListener('shown.bs.tab', function (event) {
            const selected = event.target.getAttribute('data-bs-target').substring(1);
            const url = new URL(window.location.href);
            url.searchParams.set('tab', selected);
            history.replaceState(null, '', url);
        });
    });
});
</script>
@endsection
