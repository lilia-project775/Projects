<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\StudentAction;
use App\Models\Medal;

class SchoolPanelPerformanceController extends Controller
{
    // class formance
    public function calculateClassPerformance($classId)
    {
        // Class, School and Baseline
        $class = ClassModel::with('school.baseline')->findOrFail($classId);

        if (!$class->school || !$class->school->baseline) {
            return back()->with('error', 'Baseline data not found for this school.');
        }

        $baseline = $class->school->baseline;
        $actions = StudentAction::where('class_id', $classId)->get();

        // Domain performance thresholds
        $domains = [
            'Water' => ['silver' => 10, 'gold' => 20],
            'Energy' => ['silver' => 8, 'gold' => 15],
            'Circular Waste' => ['silver' => 10, 'gold' => 25],
        ];

        $performance = [];
        $totalPercentage = 0;
        $count = 0;

        foreach ($domains as $domain => $thresholds) {
            $baselineValue = match ($domain) {
                'Water' => $baseline->water_usage_liters ?? 0,
                'Energy' => $baseline->energy_usage_kwh ?? 0,
                'Circular Waste' => $baseline->waste_generated_kg ?? 0,
                default => 0
            };

            $savedValue = $actions->where('domain', $domain)->sum('amount_saved');
            $percentage = ($baselineValue > 0) ? ($savedValue / $baselineValue) * 100 : 0;

            $medal = 'Bronze';
            if ($percentage >= $thresholds['gold']) {
                $medal = 'Gold';
            } elseif ($percentage >= $thresholds['silver']) {
                $medal = 'Silver';
            }

            $performance[$domain] = [
                'baseline' => $baselineValue,
                'saved' => $savedValue,
                'percentage' => round($percentage, 2),
                'medal' => $medal
            ];

            $totalPercentage += $percentage;
            $count++;
        }

        $average = $count > 0 ? $totalPercentage / $count : 0;
        $finalMedal = $average >= 20 ? 'Gold' : ($average >= 10 ? 'Silver' : 'Bronze');

        // Store or update the class medal
        Medal::updateOrCreate(
            ['class_id' => $class->id],
            [
                'school_id' => $class->school_id,
                'medal_type' => $finalMedal,
                'performance_percentage' => round($average, 2)
            ]
        );

        return view('school.performance.class', compact('class', 'performance', 'average', 'finalMedal'));
    }
    
    // section performance
     public function calculateSectionPerformance($sectionId)
    {
        $section = Section::with('class.school.baseline')->findOrFail($sectionId);

        if (!$section->class || !$section->class->school->baseline) {
            return back()->with('error', 'Baseline data not found for this section.');
        }

        $baseline = $section->class->school->baseline;
        $actions = StudentAction::where('section_id', $sectionId)->get();

        $domains = [
            'Water' => ['silver' => 10, 'gold' => 20],
            'Energy' => ['silver' => 8, 'gold' => 15],
            'Circular Waste' => ['silver' => 10, 'gold' => 25],
        ];

        $performance = [];
        $totalPercentage = 0;
        $count = 0;

        foreach ($domains as $domain => $thresholds) {
            $baselineValue = match ($domain) {
                'Water' => $baseline->water_usage_liters ?? 0,
                'Energy' => $baseline->energy_usage_kwh ?? 0,
                'Circular Waste' => $baseline->waste_generated_kg ?? 0,
                default => 0
            };

            $savedValue = $actions->where('domain', $domain)->sum('amount_saved');
            $percentage = ($baselineValue > 0) ? ($savedValue / $baselineValue) * 100 : 0;

            $medal = 'Bronze';
            if ($percentage >= $thresholds['gold']) $medal = 'Gold';
            elseif ($percentage >= $thresholds['silver']) $medal = 'Silver';

            $performance[$domain] = [
                'baseline' => $baselineValue,
                'saved' => $savedValue,
                'percentage' => round($percentage, 2),
                'medal' => $medal
            ];

            $totalPercentage += $percentage;
            $count++;
        }

        $average = $count ? $totalPercentage / $count : 0;
        $finalMedal = $average >= 20 ? 'Gold' : ($average >= 10 ? 'Silver' : 'Bronze');

        Medal::updateOrCreate(
            ['section_id' => $section->id],
            [
                'school_id' => $section->class->school_id,
                'class_id' => $section->class_id,
                'medal_type' => $finalMedal,
                'performance_percentage' => round($average, 2)
            ]
        );

        return view('school.performance.section', compact('section', 'performance', 'average', 'finalMedal'));
    }

    // school performance
    public function calculateSchoolPerformance($schoolId)
{
    $school = \App\Models\School::with('classes')->findOrFail($schoolId);

    $classes = $school->classes;
    $totalPerformance = 0;
    $count = 0;

    foreach ($classes as $class) {
        $classMedal = \App\Models\Medal::where('class_id', $class->id)->first();
        if ($classMedal) {
            $totalPerformance += $classMedal->performance_percentage;
            $count++;
        }
    }

    $average = $count > 0 ? $totalPerformance / $count : 0;
    $finalMedal = $average >= 20 ? 'Gold' : ($average >= 10 ? 'Silver' : 'Bronze');

    // Update or create school-level medal
    \App\Models\Medal::updateOrCreate(
        ['school_id' => $school->id, 'class_id' => null, 'section_id' => null],
        [
            'medal_type' => $finalMedal,
            'performance_percentage' => round($average, 2)
        ]
    );

    return view('school.performance.school', compact('school', 'average', 'finalMedal'));
}

    
    
}
