<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Section;
use App\Models\ClassModel;
use App\Models\School;

class AdminSectionController extends Controller
{
    public function index(Request $request)
    {
        
    $query = Section::with(['class', 'school'])->orderBy('created_at', 'desc');
    
       // Apply filter only if school_id is selected 
    if ($request->filled('school_id')) {
        $query->where('school_id', $request->school_id);
    }
     
    $sections =$query->paginate(10);
     $allSchools = School::orderBy('created_at', 'desc')->get();
    return view('admin.sections.index', compact('sections', 'allSchools'));
}
 

    public function create()
    {
        $classes = ClassModel::orderBy('created_at','desc')->get();
        $schools = School::orderBy('created_at','desc')->get();
        return view('admin.sections.create', compact('classes', 'schools'));
    }
    
    
    public function show($id)
    {
        $section = Section::with(['school', 'class'])->findOrFail($id);
        return view('admin.sections.show', compact('section'));
    }
    
    public function getClasses($school_id)
    {
        $classes = ClassModel::where('school_id', $school_id)
            ->orderBy('class_name', 'asc')
            ->get(['id', 'class_name']);
    
        return response()->json($classes);
    }

    // store
    public function store(Request $request)
{
    $validated = $request->validate([
        'school_id' => 'required|exists:schools,id',
        'class_id' => 'required|exists:classes,id',
        'section_name' => 'required|string|max:255',
    ]);

    // Check if this section already exists for this class
    $existingSection = Section::where('school_id', $request->school_id)
        ->where('class_id', $request->class_id)
        ->where('section_name', $request->section_name)
        ->first();

    if ($existingSection) {
        return back()->with('section_exists_error', 'This section already exists for the selected class!')->withInput();
    }

    // create new section
    Section::create([
        'school_id' => $request->school_id,
        'class_id' => $request->class_id,
        'section_name' => trim($request->section_name),
    ]);

    return redirect()->route('admin.section.index')->with('success', 'Section added successfully!');
}

    
    
public function edit($id)
{
    $section = Section::findOrFail($id);
    $schools = School::orderBy('created_at', 'desc')->get();
    $classes = ClassModel::where('school_id', $section->school_id)->get();

    return view('admin.sections.edit', compact('section', 'schools', 'classes'));
}

// update
public function update(Request $request, $id)
{
    // Step 1: Validation
    $request->validate([
        'school_id' => 'required|exists:schools,id',
        'class_id' => 'required|exists:classes,id',
        'section_name' => 'required|string|max:255',
    ]);

    // Step 2: Remove extra spaces and make name lowercase for checking
    $sectionName = trim($request->section_name);

    // Step 3: Check if same section already exists (except current one)
    $exists = Section::where('school_id', $request->school_id)
        ->where('class_id', $request->class_id)
        ->whereRaw('LOWER(section_name) = ?', [strtolower($sectionName)])
        ->where('id', '!=', $id)
        ->exists();

    if ($exists) {
        return back()->with('section_exists_error', 'This section already exists for the selected class!')->withInput();
    }

    // Step 4: Update record
    $section = Section::findOrFail($id);
    $section->update([
        'school_id' => $request->school_id,
        'class_id' => $request->class_id,
        'section_name' => $sectionName,
    ]);

    // Step 5: Redirect with success message
    return redirect()->route('admin.section.index')->with('success', 'Section updated successfully!');
}

    public function destroy($id)
    {
        Section::findOrFail($id)->delete();
        return back()->with('success', 'Section deleted successfully!');
    }
}
