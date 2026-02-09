<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolBaseline;
use App\Models\StudentAction;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
 

class StudentProfileController extends Controller
{
  
    //   show profile
     // Show Profile
    public function studentProfile()
    {
        $studentId = Auth::user()->student_id;
        $student = Student::with(['school', 'class', 'section'])->findOrFail($studentId);
        return view('student.profile.show', compact('student'));
    }


  
   // Edit Profile
    public function editProfile($id)
    {
        $student = Student::with(['school', 'class', 'section'])->findOrFail($id);
        return view('student.profile.edit', compact('student'));
    }

    // Update Profile
public function updateProfile(Request $request, $id)
{
    $student = Student::findOrFail($id);

    $request->validate([
        'student_name'   => 'required|string|max:255',
        'email'          => 'required|email|max:255',
        'phone'          => 'nullable|string|max:20',
        'password'       => 'nullable|string|min:6',
        'profile_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $profileImage = $student->profile_image; // Default old image

    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);

        // delete old image
        if ($student->profile_image && file_exists(public_path('uploads/'.$student->profile_image))) {
            unlink(public_path('uploads/'.$student->profile_image));
        }

        $profileImage = $filename;
    }

    $student->update([
        'student_name'  => $request->student_name,
        'email'         => $request->email,
        'phone'         => $request->phone,
        'password_words'         => $request->password,
        'password'      => $request->filled('password') ? Hash::make($request->password) : $student->password,
        'profile_image' => $profileImage,
    ]);

  // Update related user
        $user = User::where('student_id', $student->id)->first();
        if ($user) {
            $user->update([
               
                'name' => $request->student_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
                'password_words' => $request->filled('password') ? $request->password : $user->password_words,
            ]);
        }
        
        
    return redirect()->route('student.profile.show')->with('success', 'Profile updated successfully.');
}

  
}
