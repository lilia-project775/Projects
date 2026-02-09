<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchoolStudentController extends Controller
{
    /**
     * Display a listing of the students belonging to the logged-in school.
     */
   public function index(Request $request)
    {
        
        $schoolId = Auth::user()->school_id;
        $query = Student::with(['school', 'class', 'section'])->where('school_id', $schoolId)->orderBy('created_at', 'desc');
        
         // If search input is present, filter by section name
    if ($request->has('search') && !empty($request->search)) {
        $query->where('student_name', 'like', '%' . $request->search . '%');
    }
     $students=$query->paginate(10);
     
      $students->appends($request->all());
        return view('school.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new students.
     */
    public function create()
    {
        $school = Auth::user();
        $classes = ClassModel::where('school_id', $school->school_id)->get();

        return view('school.students.create', compact('classes', 'school'));
    }

    /**
     * Store a newly created student in storage.
     */
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

        // Create student
        $student = Student::create([
            'school_id' => $validated['school_id'],
            'class_id' => $validated['class_id'],
            'section_id' => $validated['section_id'],
            'student_name' => $validated['student_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'password_words' => $validated['password'],
        ]);

        // Create related user record
        User::create([
            'student_id' => $student->id,
            'school_id' => $validated['school_id'],
            'class_id' => $validated['class_id'],
             'section_id' => $validated['section_id'],
            'role_id' => 2, // 2 = Student
            'name' => $validated['student_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'password_words' => $validated['password'],
        ]);

        return redirect()->route('school.students.index')->with('success', 'Student added successfully!');
    }

    /**
     * Display the specified students.
     */
    public function show(Student $student)
    {
        $this->authorizeStudent($student);

        return view('school.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified students.
     */
    public function edit(Student $student)
    {
        $this->authorizeStudent($student);

        $schoolId = Auth::user()->school_id;
        $classes = ClassModel::where('school_id', $schoolId)->get();
        $sections = Section::where('class_id', $student->class_id)->get();

        return view('school.students.edit', compact('student', 'classes', 'sections'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $this->authorizeStudent($student);

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'student_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'password' => 'nullable|min:6',
        ]);

        // Update student record
        $student->update([
            'class_id' => $validated['class_id'],
            'section_id' => $validated['section_id'],
            'student_name' => $validated['student_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => $request->filled('password') ? Hash::make($validated['password']) : $student->password,
            'password_words' => $request->filled('password') ? $validated['password'] : $student->password_words,
        ]);

        // Update related user
        $user = User::where('student_id', $student->id)->first();
        if ($user) {
            $user->update([
                'class_id' => $validated['class_id'],
                'name' => $validated['student_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => $request->filled('password') ? Hash::make($validated['password']) : $user->password,
                'password_words' => $request->filled('password') ? $validated['password'] : $user->password_words,
            ]);
        }

        return redirect()->route('school.students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $this->authorizeStudent($student);

        User::where('student_id', $student->id)->delete();
        $student->delete();

        return redirect()->route('school.students.index')->with('success', 'Student deleted successfully!');
    }

    /**
     * AJAX - Get sections by class ID
     */
    public function getSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get(['id', 'section_name']);
        return response()->json($sections);
    }

    /**
     * Ensure that the student belongs to the logged-in school.
     */
    private function authorizeStudent(Student $student)
    {
        if ($student->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
