<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentAction;
use App\Models\School;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;

class StudentActionController extends Controller
{
    /**
     * Display all actions of the logged-in student.
     */
//   public function index(Request $request)
// {
    
//     $userId = Auth::id();
//     $activeTab = $request->get('tab', 'water');
//     $waterActions = StudentAction::where('user_id', Auth::id())->where('domain', 'Water')->latest()->paginate(10, ['*'], 'water_page');
//     $energyActions = StudentAction::where('user_id', Auth::id())->where('domain', 'Energy')->latest()->paginate(10, ['*'], 'energy_page');
//     $wasteActions = StudentAction::where('user_id', Auth::id())->where('domain', 'Waste')->latest()->paginate(10, ['*'], 'waste_page');
    
//     // sum
//     $waterTotal = StudentAction::where('user_id', $userId)->where('domain', 'Water')->sum('amount_saved');
//     $energyTotal = StudentAction::where('user_id', $userId)->where('domain', 'Energy')->sum('amount_saved');
//     $wasteTotal = StudentAction::where('user_id', $userId)->where('domain', 'Waste')->sum('amount_saved');
        
//     return view('student.actions.index', compact('waterActions', 'energyActions', 'wasteActions', 'activeTab','waterTotal', 'energyTotal', 'wasteTotal'));
// }
//  public function index(Request $request)
// {
//     $userId = Auth::id();
//     $activeTab = $request->get('tab', 'water');

//     // Water Actions
//     $waterQuery = StudentAction::where('user_id', $userId)->where('domain', 'Water');
//     if ($request->water_from_date) {
//         $waterQuery->whereDate('created_at', '>=', $request->water_from_date);
//     }
//     if ($request->water_to_date) {
//         $waterQuery->whereDate('created_at', '<=', $request->water_to_date);
//     }
//     $waterActions = $waterQuery->latest()->paginate(10, ['*'], 'water_page');

//     // Energy Actions
//     $energyQuery = StudentAction::where('user_id', $userId)->where('domain', 'Energy');
//     if ($request->energy_from_date) {
//         $energyQuery->whereDate('created_at', '>=', $request->energy_from_date);
//     }
//     if ($request->energy_to_date) {
//         $energyQuery->whereDate('created_at', '<=', $request->energy_to_date);
//     }
//     $energyActions = $energyQuery->latest()->paginate(10, ['*'], 'energy_page');

//     // Waste Actions
//     $wasteQuery = StudentAction::where('user_id', $userId)->where('domain', 'Waste');
//     if ($request->waste_from_date) {
//         $wasteQuery->whereDate('created_at', '>=', $request->waste_from_date);
//     }
//     if ($request->waste_to_date) {
//         $wasteQuery->whereDate('created_at', '<=', $request->waste_to_date);
//     }
//     $wasteActions = $wasteQuery->latest()->paginate(10, ['*'], 'waste_page');

//     // Sum
//     $waterTotal = $waterQuery->sum('amount_saved');
//     $energyTotal = $energyQuery->sum('amount_saved');
//     $wasteTotal = $wasteQuery->sum('amount_saved');

//     return view('student.actions.index', compact(
//         'waterActions', 'energyActions', 'wasteActions', 
//         'activeTab','waterTotal', 'energyTotal', 'wasteTotal'
//     ));
// }

public function index(Request $request)
{
    $userId = Auth::id(); 
    $activeTab = $request->get('tab', 'water');

    // Water Actions
    $waterQuery = StudentAction::where('user_id', $userId)->where('domain', 'Water');
    if ($request->water_from_date && $request->water_to_date) {
        $waterQuery->whereBetween('created_at', [$request->water_from_date, $request->water_to_date]);
    }
    $waterActions = $waterQuery->latest()->paginate(10, ['*'], 'water_page');

    // Energy Actions
    $energyQuery = StudentAction::where('user_id', $userId)->where('domain', 'Energy');
    if ($request->energy_from_date && $request->energy_to_date) {
        $energyQuery->whereBetween('created_at', [$request->energy_from_date, $request->energy_to_date]);
    }
    $energyActions = $energyQuery->latest()->paginate(10, ['*'], 'energy_page');

    // Waste Actions
    $wasteQuery = StudentAction::where('user_id', $userId)->where('domain', 'Waste');
    if ($request->waste_from_date && $request->waste_to_date) {
        $wasteQuery->whereBetween('created_at', [$request->waste_from_date, $request->waste_to_date]);
    }
    $wasteActions = $wasteQuery->latest()->paginate(10, ['*'], 'waste_page');

    // Sum
    $waterTotal = $waterQuery->sum('amount_saved');
    $energyTotal = $energyQuery->sum('amount_saved');
    $wasteTotal = $wasteQuery->sum('amount_saved');

    return view('student.actions.index', compact(
        'waterActions', 'energyActions', 'wasteActions', 
        'activeTab','waterTotal', 'energyTotal', 'wasteTotal'
    ));
}


 
    /**
     * Show form to log new action.
     */
    public function create()
    {
        $studentId = Auth::user()->student_id;
        // Get the student record with related school, class, and section
        $student =Student::with(['school', 'class', 'section'])->findOrFail($studentId);
    
        $school = $student->school;
        $class = $student->class;
        $section = $student->section;
    
        return view('student.actions.create', compact('school', 'class', 'section'));
    }


    /**
     * Store new student action.
     */
  public function store(Request $request)
{
    $data = $request->validate([
        'school_id' => 'required',
        'class_id' => 'required',
        'domain' => 'required',
        'section_id' => 'required',
        'amount_saved_liters' => 'nullable|numeric|min:1',
        'amount_saved_kwh' => 'nullable|numeric|min:1',
        'amount_saved_kg' => 'nullable|numeric|min:1',
        'unit' => 'nullable|string',
    ]);

    // Determine correct amount_saved value
    if ($data['domain'] === 'Water') {
        $amount_saved = $data['amount_saved_liters'];
    } elseif ($data['domain'] === 'Energy') {
        $amount_saved = $data['amount_saved_kwh'];
    } else {
        $amount_saved = $data['amount_saved_kg'];
    }

    // Save action
    StudentAction::create([
        'user_id' => Auth::id(),
        'school_id' => $data['school_id'],
        'class_id' => $data['class_id'],
        'section_id' => $data['section_id'],
        'domain' => $data['domain'],
        'amount_saved' => $amount_saved,
        'unit' => $data['unit'],
    ]);

    return redirect()->route('student.actions.index')->with('success', 'Action added successfully!');
}
 
    /**
     * Show edit form.
     */
   public function edit($id)
{
    $action = StudentAction::with(['school', 'class', 'section'])->findOrFail($id);
    return view('student.actions.edit', compact('action'));
}



    /**
     * Update existing action.
     */
public function update(Request $request, $id)
{
    $data = $request->validate([
        'school_id' => 'required',
        'class_id' => 'required',
        'domain' => 'required',
        'section_id' => 'required',
        'amount_saved_liters' => 'nullable|numeric|min:1',
        'amount_saved_kwh' => 'nullable|numeric|min:1',
        'amount_saved_kg' => 'nullable|numeric|min:1',
        'unit' => 'nullable|string',
    ]);

    // Record find karo
    $action = StudentAction::findOrFail($id);

    // Domain ke hisaab se correct amount_saved value determine karo
    if ($data['domain'] === 'Water') {
        $amount_saved = $data['amount_saved_liters'];
    } elseif ($data['domain'] === 'Energy') {
        $amount_saved = $data['amount_saved_kwh'];
    } else {
        $amount_saved = $data['amount_saved_kg'];
    }

    // Update record
    $action->update([
        'user_id' => Auth::id(),
        'school_id' => $data['school_id'],
        'class_id' => $data['class_id'],
        'section_id' => $data['section_id'],
        'domain' => $data['domain'],
        'amount_saved' => $amount_saved,
        'unit' => $data['unit'],
    ]);

    return redirect()->route('student.actions.index')->with('success', 'Action updated successfully!');
}


 /**
     * Show a student action.
     */
     
     
public function show($id)
{
    $action = StudentAction::with(['school', 'class', 'section'])->findOrFail($id);
    return view('student.actions.show', compact('action'));
}

    /**
     * Delete a student action.
     */
     
     
    public function destroy($id)
    {
        $action = StudentAction::where('user_id', Auth::id())->findOrFail($id);
        $action->delete();

        return redirect()->route('student.actions.index')->with('success', 'Action deleted successfully!');
    }
}
