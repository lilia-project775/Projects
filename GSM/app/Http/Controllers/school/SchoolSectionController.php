<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Section;
use App\Models\ClassModel;
 
class SchoolSectionController extends Controller
{
    public function index(Request $request)
{
    // Base query: only sections belonging to the logged-in school
    $query = Section::with(['class','students'])->where('school_id', Auth::user()->school_id)->orderBy('created_at', 'desc');

    // If search input is present, filter by section name
    if ($request->has('search') && !empty($request->search)) {
        $query->where('section_name', 'like', '%' . $request->search . '%');
    }

    // Paginate the results
    $sections = $query->paginate(10);

    // Preserve search query in pagination links
    $sections->appends($request->all());

    return view('school.section.index', compact('sections'));
}

    public function create()
    {
        $school = Auth::user()->school; // current logged-in school info
        $classes = ClassModel::where('school_id', Auth::user()->school_id)
            ->orderBy('class_name', 'asc')
            ->get();

        return view('school.section.create', compact('school', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
    
        Section::create([
            'school_id' => Auth::user()->school_id,
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
        ]);

        return redirect()->route('school.section.index')->with('success', 'Section added successfully!');
    }

    public function show($id)
    {
        $section = Section::with('class')->where('school_id', Auth::user()->school_id)->findOrFail($id);
        return view('school.section.show', compact('section'));
    }

    public function edit($id)
    {
        $section = Section::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $school = Auth::user()->school;
        $classes = ClassModel::where('school_id', Auth::user()->school_id)->get();

        return view('school.section.edit', compact('section', 'school', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
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
    
    
        $section = Section::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $section->update([
            'class_id' => $request->class_id,
            'section_name' => $request->section_name,
        ]);

        return redirect()->route('school.section.index')->with('success', 'Section updated successfully!');
    }

    public function destroy($id)
    {
        $section = Section::where('school_id', Auth::user()->school_id)->findOrFail($id);
        $section->delete();

        return redirect()->route('school.section.index')->with('success', 'Section deleted successfully!');
    }
}
