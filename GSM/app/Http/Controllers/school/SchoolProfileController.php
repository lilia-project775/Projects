<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolBaseline;
use App\Models\StudentAction;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
use App\Models\School;


class SchoolProfileController extends Controller
{
  
//   show profile
  public function schoolProfile()
  {
      $schoolId=Auth::user()->school_id;
       $school =School::findOrFail($schoolId);
      return view('school.profile.show',compact('school'));
  }
  
//   show edit
   // Edit profile form
    public function editProfile()
    {
        $schoolId = Auth::user()->school_id;
        $school = School::findOrFail($schoolId);
        return view('school.profile.edit', compact('school'));
    }

    //  Update school profile
    public function updateProfile(Request $request)
    {
        $schoolId = Auth::user()->school_id;
        $school = School::findOrFail($schoolId);

        $validated = $request->validate([
            'school_name'     => 'required|string|max:255',
            'type'            => 'nullable|string|max:255',
            'contact_person'  => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'nullable|string|max:20',
            'district_region' => 'nullable|string|max:255',
            'address'         => 'nullable|string|max:500',
            'logo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('uploads'), $logoName);
            $validated['logo'] = $logoName;
        }

        $school->update($validated);

        return redirect()->route('school.profile.show')
                         ->with('success', 'Profile updated successfully!');
    }
  
}
