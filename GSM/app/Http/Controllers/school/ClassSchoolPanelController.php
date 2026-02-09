<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassSchoolPanelController extends Controller
{
    public function index(Request $request)
    {
        // Show all classes of this school
        $query = ClassModel::where('school_id', Auth::user()->school_id)->orderBy('created_at', 'desc');
               
        // If search input is present, filter by section name
    if ($request->search && !empty($request->search)) {
        $query->where('class_name', 'like', '%' . $request->search . '%');
    }
      $classes=$query->paginate(10);
     
      $classes->appends($request->all());
      
        return view('school.class.index', compact('classes'));
    }

    public function create()
    {
        $school = Auth::user(); // current logged-in school
        return view('school.class.create', compact('school'));
    }
    
     public function show(ClassModel $class){
          return view('school.class.show', compact('class'));

}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
        ]);
  $existingClass = ClassModel::where('school_id', $request->school_id)->where('class_name', $request->class_name)->first();

    if ($existingClass) {
        return back()->with('class_exists_error', 'This class already exists for the selected school!')->withInput();
    }
     
        ClassModel::create([
            'school_id' =>$request->school_id,
            'class_name' => $request->class_name,
        ]); 

        return redirect()->route('school.class.index')
            ->with('success', 'Class added successfully!');
    }

    public function edit(ClassModel $class)
    {
        $school = Auth::user();
        return view('school.class.edit', compact('class', 'school'));
    }

    public function update(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
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
        $class->update([
            'class_name' => $request->class_name,
        ]);

        return redirect()->route('school.class.index')
            ->with('success', 'Class updated successfully!');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();
        return redirect()->route('school.class.index')
            ->with('success', 'Class deleted successfully!');
    }
}
