<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\SchoolBaseline;
use App\Models\StudentAction;
use App\Models\ClassModel;

class SchoolDashboardController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;

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

        return view('school.dashboard', compact('chartData', 'domainSums'));
    }
}
