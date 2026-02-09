<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolBaseline;
use App\Models\StudentAction;
use App\Models\ClassModel;
use App\Models\School;

class AdminDashboardcontroller extends Controller
{

    
    public function index(Request $request)
{
    // ✅ Step 1: Get selected school_id (if any)
    $schoolId = $request->get('school_id');

    // ✅ Step 2: If not provided, use the latest or first school as default
    if (!$schoolId) {
        $schoolId = School::orderBy('id', 'asc')->value('id'); // You can use 'desc' if you prefer latest school
    }

    // ✅ Step 3: Check baseline
    $baseline = SchoolBaseline::where('school_id', $schoolId)->first();
    if (!$baseline) {
        return back()->with('error', 'No baseline data found for this school.');
    }

    // ✅ Step 4: Baseline data
    $domains = [
        'Water'  => $baseline->water_usage_liters,
        'Waste'  => $baseline->waste_generated_kg,
        'Energy' => $baseline->energy_usage_kwh,
    ];

    // ✅ Step 5: Classes & actions
    $classes = ClassModel::where('school_id', $schoolId)->get();

    $chartData = [
        'Water'  => [],
        'Waste'  => [],
        'Energy' => [],
    ];

    $domainSums = [
        'Water'  => 0,
        'Waste'  => 0,
        'Energy' => 0,
    ];

    foreach ($classes as $class) {
        $actions = StudentAction::where('school_id', $schoolId)
            ->where('class_id', $class->id)
            ->selectRaw('domain, SUM(amount_saved) as total_saved')
            ->groupBy('domain')
            ->pluck('total_saved', 'domain')
            ->toArray();

        foreach (['Water', 'Waste', 'Energy'] as $domain) {
            $total = $domains[$domain] ?? 0;
            $obtained = $actions[$domain] ?? 0;
            $percentage = $total > 0 ? round(($obtained / $total) * 100, 2) : 0;

            $chartData[$domain][] = [
                'class' => $class->class_name,
                'percentage' => $percentage,
            ];

            $domainSums[$domain] += $percentage;
        }
    }

    // ✅ Step 6: Get all schools for dropdown
    $allSchools = School::orderBy('created_at', 'desc')->get();

    // ✅ Step 7: Return view
    return view('admin.dashboard', compact('chartData', 'domainSums', 'allSchools', 'schoolId'));
}

    // filter
    public function schoolWisePerformancefilter(Request $request){
    
        $schoolId = $request->school_id;

        $baseline = SchoolBaseline::where('school_id', $schoolId)->first();
        if (!$baseline) {
            return back()->with('error', 'No baseline data found for this school.');
        }

        // Baseline totals
        $domains = [
            'Water' => $baseline->water_usage_liters,
            'Waste' => $baseline->waste_generated_kg,
            'Energy' => $baseline->energy_usage_kwh,
        ];

        $classes = ClassModel::where('school_id', $schoolId)->get();

        $chartData = [
            'Water' => [],
            'Waste' => [],
            'Energy' => [],
        ];

        $domainSums = [
            'Water' => 0,
            'Waste' => 0,
            'Energy' => 0,
        ];

        foreach ($classes as $class) {
            $actions = StudentAction::where('school_id', $schoolId)
                ->where('class_id', $class->id)
                ->selectRaw('domain, SUM(amount_saved) as total_saved')
                ->groupBy('domain')
                ->pluck('total_saved', 'domain')
                ->toArray();

            foreach (['Water', 'Waste', 'Energy'] as $domain) {
                $total = $domains[$domain] ?? 0;
                $obtained = $actions[$domain] ?? 0;
                $percentage = $total > 0 ? round(($obtained / $total) * 100, 2) : 0;

                $chartData[$domain][] = [
                    'class' => $class->class_name,
                    'percentage' => $percentage,
                ];

                // Add to sum
                $domainSums[$domain] += $percentage;
            }
        }

$allSchools=School::orderBy('created_at','desc')->get();
return response()->json([
    'success' => true,
    'message' => "Filter applied successfully.",
    'chartData' => $chartData,
    'domainSums' => $domainSums,
]);


    }
}
