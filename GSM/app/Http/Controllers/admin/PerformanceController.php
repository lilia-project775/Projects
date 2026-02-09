<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Medal;

class PerformanceController extends Controller
{
    public function calculateSchoolPerformance($schoolId)
    {
        $school = School::with('classes')->findOrFail($schoolId);

        $classes = $school->classes;
        $totalPerformance = $classes->sum(function ($class) {
            return Medal::where('class_id', $class->id)->value('performance_percentage') ?? 0;
        });

        $count = $classes->count();
        $average = $count ? $totalPerformance / $count : 0;

        $finalMedal = $average >= 20 ? 'Gold' : ($average >= 10 ? 'Silver' : 'Bronze');

        Medal::updateOrCreate(
            ['school_id' => $school->id, 'class_id' => null, 'section_id' => null],
            [
                'medal_type' => $finalMedal,
                'performance_percentage' => round($average, 2)
            ]
        );
        return view('admin.performance.school', compact('school', 'average', 'finalMedal'));
    }
}
