<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\School;
use App\Models\SchoolBaseline;
use App\Models\User;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
    {
        $query = School::orderBy('created_at', 'desc');
        
        if($request->search && !empty($request->search)){
            $query->where('school_name' , 'like' , '%' . $request->search . '%');
        }
        
        $schools=$query->paginate(10);
        $schools->appends($request->all());
        
        return view('admin.schools.index', compact('schools')); 
    }
  
    /**
     * Show the form for creating a new school.
     */
    public function create()
    {
        // get all users who can be Green Captains (students)
        $captains = User::where('role_id', 2)->orderBy('name')->get();
        return view('admin.schools.create', compact('captains'));
    }

    /**
     * Store a newly created school in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'school_name' => 'required|string|max:255',
        'address' => 'required|string',
        'district_region' => 'required|string|max:255',
        'contact_person' => 'required|string|max:255',
        'email' => 'required|email|unique:schools',
        'phone' => 'required|string|max:50',
        'type' => 'required|in:Public,Private',
        // 'total_classes' => 'required|integer|min:1',
        // 'green_captain_id' => 'nullable|exists:users,id',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        // 'map_pin' => 'nullable|string|max:255',
        // 'water_usage_liters' => 'required|numeric|min:0',
        // 'energy_usage_kwh' => 'required|numeric|min:0',
        // 'waste_generated_kg' => 'required|numeric|min:0',
        'password' => 'required|string|min:8', // ✅ added this line
    ]);

    $fileName = null;
    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $fileName = now()->timestamp . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $fileName);
    }

    // Create school
    $school = School::create([
        'school_name' => $validated['school_name'],
        'address' => $validated['address'],
        'district_region' => $validated['district_region'],
        'contact_person' => $validated['contact_person'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
       'password' => Hash::make($validated['password']), // for login
    'password_words' => $request->password,
        'type' => $validated['type'],
        // 'total_classes' => $validated['total_classes'],
        // 'green_captain_id' => $validated['green_captain_id'] ?? null,
        'logo' => $fileName,
        // 'map_pin' => $validated['map_pin'] ?? null,
    ]);

    // Create baseline data
    // $school->baseline()->create([
    //     'water_usage_liters' => $validated['water_usage_liters'],
    //     'energy_usage_kwh' => $validated['energy_usage_kwh'],
    //     'waste_generated_kg' => $validated['waste_generated_kg'],
    // ]);
 
    // Create school user
    User::create([
        'school_id' => $school->id,
        'role_id' => 3,
        'name' => $validated['school_name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'password' => Hash::make($validated['password']), // for login
         'password_words' => $request->password,
    ]);

    return redirect()->route('admin.schools.index')->with('success', 'School added successfully.');
}
 
    /**
     * Show the form for show a school.
     */
    public function show(School $school)
    {
        // $school->load('greenCaptain', 'baseline');
        return view('admin.schools.show', compact('school'));
    }

    /**
     * Show the form for editing a school.
     */
    public function edit(School $school)
    {
        $captains = User::where('role_id', 2)->orderBy('name')->get();
        return view('admin.schools.edit', compact('school', 'captains'));
    }

    /**
     * Update a school.
     */
   public function update(Request $request, $id)
{
    $school = School::findOrFail($id);

    $validated = $request->validate([
        'school_name' => 'required|string|max:255',
        'address' => 'required|string',
        'district_region' => 'required|string|max:255',
        'contact_person' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:50',
        'type' => 'required|in:Public,Private',
        // 'total_classes' => 'required|integer|min:1',
        // 'green_captain_id' => 'nullable|exists:users,id',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        // 'map_pin' => 'nullable|string|max:255',
        // 'water_usage_liters' => 'required|numeric|min:0',
        // 'energy_usage_kwh' => 'required|numeric|min:0',
        // 'waste_generated_kg' => 'required|numeric|min:0',
        'password' => 'required|string|min:8', // optional for update
    ]);

    // ✅ Handle logo update
    $fileName = $school->logo;
    if ($request->hasFile('logo')) {
        // delete old logo if exists
        if ($school->logo && file_exists(public_path('uploads/' . $school->logo))) {
            unlink(public_path('uploads/' . $school->logo));
        }

        $file = $request->file('logo');
        $fileName = now()->timestamp . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $fileName);
    }
    
    // ✅ Update school data
    $school->update([
        'school_name' => $validated['school_name'],
        'address' => $validated['address'],
        'district_region' => $validated['district_region'],
        'contact_person' => $validated['contact_person'],
        'email' => $validated['email'],
        'password' => !empty($validated['password']) ? Hash::make($validated['password']) : $user->password,
          'password_words' => $request->password,
        'phone' => $validated['phone'],
        'type' => $validated['type'],
        // 'total_classes' => $validated['total_classes'],
        // 'green_captain_id' => $validated['green_captain_id'] ?? null,
        'logo' => $fileName,
        // 'map_pin' => $validated['map_pin'] ?? null,
    ]);
 
    // ✅ Update baseline data
    // $school->baseline()->updateOrCreate(
    //     ['school_id' => $school->id],
    //     [
    //         'water_usage_liters' => $validated['water_usage_liters'],
    //         'energy_usage_kwh' => $validated['energy_usage_kwh'],
    //         'waste_generated_kg' => $validated['waste_generated_kg'],
    //     ]
    // );

    // ✅ Update school user info (same email as school)
    $user = User::where('school_id', $school->id)->first();
    if ($user) {
        $user->update([
            'name' => $validated['school_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            // password only if provided
            'password' => !empty($validated['password']) ? Hash::make($validated['password']) : $user->password,
             'password_words' => $request->password,
        ]);
    }
 
    return redirect()->route('admin.schools.index')->with('success', 'School updated successfully.');
}



    /**
     * Delete school
     */
    public function destroy(School $school)
    {
        // Get old logo file path before deleting record
        $oldFile = public_path('uploads/') . $school->logo;

        // Delete the file if it exists
        if ($school->logo && file_exists($oldFile)) {
            unlink($oldFile);
        }

 // Delete related users first ye has many kelye
    // $school->users()->delete();
    
     // Delete related user (if exists)
    if ($school->user) {
        $school->user->delete();
    }

        // Now delete the school record
        $school->delete();

        return redirect()->route('admin.schools.index')
            ->with('success', 'School deleted successfully.');
    }

}
