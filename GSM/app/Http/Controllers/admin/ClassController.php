<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\School;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassModel::with('school')->latest();
       
       // Apply filter only if school_id is selected 
    if ($request->filled('school_id')) {
        $query->where('school_id', $request->school_id);
    }
    
        $classes = $query->paginate(10);
         $allSchools = School::orderBy('created_at', 'desc')->get();
        return view('admin.classes.index', compact('classes', 'allSchools'));
    }

    public function create()
    {
        $schools = School::orderBy('created_at','desc')->get();
        return view('admin.classes.create', compact('schools'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'school_id'  => 'required|exists:schools,id',
        'class_name' => 'required|string|max:255',
    ]);

    // eck if this class already exists for this school
    $existingClass = ClassModel::where('school_id', $request->school_id)->where('class_name', $request->class_name)->first();

    if ($existingClass) {
        return back()->with('class_exists_error', 'This class already exists for the selected school!')->withInput();
    }

    // eate new class
    ClassModel::create([
        'school_id'  => $request->school_id,
        'class_name' => $request->class_name,
    ]);

    return redirect()
        ->route('admin.classes.index')
        ->with('success', 'Class added successfully!');
}


    public function show(ClassModel $class)
    {
        return view('admin.classes.show', compact('class'));
    }

    public function edit(ClassModel $class)
    {
        $schools = School::orderBy('created_at','desc')->get();;
        return view('admin.classes.edit', compact('class', 'schools'));
    }

public function update(Request $request, ClassModel $class)
{
    // Step 1: Validate data
    $request->validate([
        'school_id'  => 'required|exists:schools,id',
        'class_name' => 'required|string|max:255',
    ]);

    // Step 2: Trim spaces and make name lowercase for accurate comparison
    $className = trim($request->class_name);

    // Step 3: Check if another class with same name already exists for the school
    $exists = ClassModel::where('school_id', $request->school_id)
        ->whereRaw('LOWER(class_name) = ?', [strtolower($className)])
        ->where('id', '!=', $class->id)
        ->exists();

    if ($exists) {
        return back()->with('class_exists_error', 'This class already exists for the selected school!')->withInput();
    }

    // Step 4: Update the class record
    $class->update([
        'school_id'  => $request->school_id,
        'class_name' => $className,
    ]);

    // Step 5: Redirect with success message
    return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully!');
}



    public function destroy(ClassModel $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully!');
    }
}
