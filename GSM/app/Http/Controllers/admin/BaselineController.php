<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\SchoolBaseline;

class BaselineController extends Controller
{
    
  public function index(Request $request)
{
    $query = SchoolBaseline::with('school')->latest();

    if ($request->search && !empty($request->search)) {
        $query->whereHas('school', function($q) use ($request) {
            $q->where('school_name', 'like', '%' . $request->search . '%');
        });
    }

    $baselines = $query->paginate(10);
    $baselines->appends($request->all());

    return view('admin.baseline.index', compact('baselines'));
}

    public function create()
    {
        $schools = School::all();
        return view('admin.baseline.create', compact('schools'));
    }
public function show($id)
{
    $baseline = SchoolBaseline::with('school')->findOrFail($id);
    return view('admin.baseline.show', compact('baseline'));
}

    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'water_usage_liters' => 'required|numeric|min:0',
            'energy_usage_kwh' => 'required|numeric|min:0',
            'waste_generated_kg' => 'required|numeric|min:0',
        ]);

        SchoolBaseline::create($request->all());

        return redirect()->route('admin.baseline.index')
            ->with('success', 'Baseline data added successfully!');
    }

    public function edit($id)
    {
        $baseline = SchoolBaseline::findOrFail($id);
        $schools = School::all();
        return view('admin.baseline.edit', compact('baseline', 'schools'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'water_usage_liters' => 'required|numeric|min:0',
            'energy_usage_kwh' => 'required|numeric|min:0',
            'waste_generated_kg' => 'required|numeric|min:0',
        ]);

        $baseline = SchoolBaseline::findOrFail($id);
        $baseline->update($request->all());

        return redirect()->route('admin.baseline.index')
            ->with('success', 'Baseline data updated successfully!');
    }

    public function destroy($id)
    {
        $baseline = SchoolBaseline::findOrFail($id);
        $baseline->delete();

        return redirect()->route('admin.baseline.index')
            ->with('success', 'Baseline data deleted successfully!');
    }
}
