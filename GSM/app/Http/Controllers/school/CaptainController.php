<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class CaptainController extends Controller
{
    /**
     * Show Assign / Update Captain Page
     */
    public function index()
    {
        $school_id = Auth::user()->school_id;
        $classes = ClassModel::where('school_id', $school_id)->get();

        // Get all current captains of this school
        $captains = Student::where('school_id', $school_id)
            ->where('is_captain', true)
            ->with(['class', 'section'])
            ->get();

        return view('school.captain.assign', compact('classes', 'captains'));
    }

    /**
     * Get Sections based on Class
     */
    public function getSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();
        return response()->json($sections);
    }

    /**
     * Get Students based on Section
     */
    public function getStudents($section_id)
    {
        $students = Student::where('section_id', $section_id)->get();
        return response()->json($students);
    }

    /**
     * Assign New Captain
     */
    public function assign(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'section_id' => 'required',
            'student_id' => 'required',
        ]);

        // Remove existing captain in that section
        Student::where('section_id', $request->section_id)->where('school_id', $request->school_id)
            ->update(['is_captain' => false]);

        // Assign new captain
        $student = Student::findOrFail($request->student_id);
        $student->is_captain = true;
        $student->save();

        return redirect()->back()->with('success', 'Captain assigned successfully!');
    }

    /**
     * Show Edit Captain Form
     */
  public function edit($id)
{
    $school_id = Auth::user()->school_id;

    // Find student to edit
    $student = Student::where('id', $id)
        ->where('school_id', $school_id)
        ->firstOrFail();

    // Get all classes for this school
    $classes = ClassModel::where('school_id', $school_id)->get();

    // Get sections for the student's class
    $sections = Section::where('class_id', $student->class_id)->get();

    // Get students for the student's section
    $students = Student::where('section_id', $student->section_id)
        ->where('school_id', $school_id)
        ->get();

    return view('school.captain.edit', compact('student', 'classes', 'sections', 'students'));
}


    /**
     * Update Captain
     */
  public function update(Request $request, $id)
{
    $request->validate([
        'class_id' => 'required',
        'section_id' => 'required',
        'student_id' => 'required',
    ]);

    // Reset old captains in same section
    Student::where('section_id', $request->section_id)->where('school_id', $request->school_id)->update(['is_captain' => false]);

    // Assign new captain
    $student = Student::findOrFail($request->student_id);
    $student->is_captain = true;
    $student->save();

    return redirect()->route('school.captain.index')->with('success', 'Captain updated successfully!');
}


    /**
     * Remove Captain (set back to normal student)
     */
    public function remove($id)
    {
        $student = Student::findOrFail($id);
        $student->is_captain = false;
        $student->save();

        return redirect()->back()->with('success', 'Captain removed successfully!');
    }
}
