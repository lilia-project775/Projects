<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\School;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    
    
 public function index(Request $request)
{
    $query = Student::with(['school', 'class', 'section'])->latest();

    // Apply filter only if school_id is selected 
    if ($request->filled('school_id')) {
        $query->where('school_id', $request->school_id);
    }

    $students = $query->paginate(10);
    $allSchools = School::orderBy('created_at', 'desc')->get();

    return view('admin.students.index', compact('students', 'allSchools'));
}


    public function create()
    {
        $schools = School::orderBy('created_at','desc')->get();
        $classes = ClassModel::orderBy('created_at','desc')->get();
        $sections = Section::orderBy('created_at','desc')->get();
        return view('admin.students.create', compact('schools', 'classes', 'sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'student_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|min:6',
        ]);

       $student= Student::create([
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'student_name' => $request->student_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_words' => $request->password,
        ]);
        
         // Create school user
      User::create([
         'student_id' => $student->id,
        'school_id' => $request->school_id,
        'class_id' => $request->class_id,
        'role_id' => 2,
        'name' => $validated['student_name'],
        'email' =>  $request->email,
        'phone' => $request->phone,
        'password' =>  Hash::make($request->password),
         'password_words' => $request->password,
    ]);

        return redirect()->route('admin.students.index')->with('success', 'Student added successfully!');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $schools = School::orderBy('created_at','desc')->get();
        $classes = ClassModel::orderBy('created_at','desc')->get();
        $sections = Section::orderBy('created_at','desc')->get();
        return view('admin.students.edit', compact('student', 'schools', 'classes', 'sections'));
    }

    public function update(Request $request, Student $student)
{
    $validated = $request->validate([
        'school_id' => 'required|exists:schools,id',
        'class_id' => 'required|exists:classes,id',
        'section_id' => 'required|exists:sections,id',
        'student_name' => 'required|string|max:255',
        'phone' => 'required|string|max:50',
        'email' => 'required|email|unique:students,email,' . $student->id,
        'password' => 'nullable|min:6',
    ]);

    // Update Student
    $student->update([
        'school_id' => $request->school_id,
        'class_id' => $request->class_id,
        'section_id' => $request->section_id,
        'student_name' => $request->student_name,
        'phone' => $request->phone,
        'email' => $request->email,
        'password' => $request->filled('password') ? Hash::make($request->password) : $student->password,
        'password_words' => $request->filled('password') ? $request->password : $student->password_words,
    ]);

    // Related User ko update karna
    $user = User::where('student_id', $student->id)->first();
    if ($user) {
        $user->update([
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'role_id' => 2,
            'name' => $request->student_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'password_words' => $request->filled('password') ? $request->password : $user->password_words,
        ]);
    }

    return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
}

  public function destroy(Student $student)
{
    // Related user delete karo
    User::where('student_id', $student->id)->delete();

    // Student delete karo
    $student->delete();

    return redirect()->route('admin.students.index')
        ->with('success', 'Student and related user deleted successfully!');
}

    
     // AJAX - Get Classes based on School
    public function getClasses($school_id)
    {
        $classes = ClassModel::where('school_id', $school_id)->get();
        return response()->json($classes);
    }

    // AJAX - Get Sections based on Class
    public function getSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();
        return response()->json($sections);
    }
}
