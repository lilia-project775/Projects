<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DomainTarget;

class DomainTargetController extends Controller
{
    public function index()
    {
        $targets = DomainTarget::all();
        return view('admin.targets.index', compact('targets'));
    }

    public function create()
    {
        return view('admin.targets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string|unique:domain_targets,domain',
            'bronze_threshold' => 'required|numeric|min:0',
            'silver_threshold' => 'required|numeric|min:0',
            'gold_threshold' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        DomainTarget::create($validated);

        return redirect()->route('admin.targets.index')->with('success', 'Domain target created successfully.');
    }

    public function edit(DomainTarget $target)
    {
        return view('admin.targets.edit', compact('target'));
    }

    public function update(Request $request, DomainTarget $target)
    {
        $validated = $request->validate([
            'bronze_threshold' => 'required|numeric|min:0',
            'silver_threshold' => 'required|numeric|min:0',
            'gold_threshold' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $target->update($validated);
        return redirect()->route('admin.targets.index')->with('success', 'Domain target updated successfully.');
    }

    public function destroy(DomainTarget $target)
    {
        $target->delete();
        return redirect()->route('admin.targets.index')->with('success', 'Domain target deleted successfully.');
    }
}
