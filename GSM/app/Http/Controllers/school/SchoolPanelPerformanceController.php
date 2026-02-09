<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAction;
use App\Models\Medal;

class SchoolPanelPerformanceController extends Controller
{
    // -------------------------------
    // CLASS PERFORMANCE CALCULATION
    // -------------------------------
    public function calculateClassPerformance($classId)
    {
        $class = ClassModel::with('school.baseline')->findOrFail($classId);

        if (!$class->school || !$class->school->baseline) {
            return back()->with('error', 'Baseline data not found for this school.');
        }

        $baseline = $class->school->baseline;
        $actions = StudentAction::where('class_id', $classId)->get();

        // Define thresholds according to your table
        $domains = [
            'Water' => ['silver' => 10, 'gold' => 20],
            'Energy' => ['silver' => 8,  'gold' => 15],
            'Waste' => ['silver' => 10, 'gold' => 25],
        ];

        $performance = [];
        $totalPercentage = 0;
        $count = 0;

        foreach ($domains as $domain => $thresholds) {
            $baselineValue = match ($domain) {
                'Water' => $baseline->water_usage_liters ?? 0,
                'Energy' => $baseline->energy_usage_kwh ?? 0,
                'Waste' => $baseline->waste_generated_kg ?? 0,
                default => 0
            };

            $savedValue = $actions->where('domain', $domain)->sum('amount_saved');
            $percentage = ($baselineValue > 0) ? ($savedValue / $baselineValue) * 100 : 0;

            // Determine Medal
            $medal = 'Bronze'; // default (active domain)
            if ($percentage >= $thresholds['gold']) {
                $medal = 'Gold';
            } elseif ($percentage >= $thresholds['silver']) {
                $medal = 'Silver';
            }

            // Save performance info
            $performance[$domain] = [
                'baseline'   => $baselineValue,
                'saved'      => $savedValue,
                'percentage' => round($percentage, 2),
                'medal'      => $medal,
            ];

            $totalPercentage += $percentage;
            $count++;
        }

        $average = $count > 0 ? $totalPercentage / $count : 0;

        // Overall medal (based on average)
        $finalMedal = $average >= 20 ? 'Gold' : ($average >= 10 ? 'Silver' : 'Bronze');

        // Save or update record
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

    // -------------------------------
    // SECTION PERFORMANCE CALCULATION
    // -------------------------------
    
    public function calculateSectionPerformance($sectionId)
    {
        $section = Section::with('class.school.baseline')->findOrFail($sectionId);

        if (!$section->class || !$section->class->school->baseline) {
            return back()->with('error', 'Baseline data not found for this section.');
        }

        $baseline = $section->class->school->baseline;
        $actions = StudentAction::where('section_id', $sectionId)->get();

        // Define thresholds according to your table
        $domains = [
            'Water' => ['silver' => 10, 'gold' => 20],
            'Energy' => ['silver' => 8,  'gold' => 15],
            'Waste' => ['silver' => 10, 'gold' => 25],
        ];

        $performance = [];
        $totalPercentage = 0;
        $count = 0;

        foreach ($domains as $domain => $thresholds) {
            $baselineValue = match ($domain) {
                'Water' => $baseline->water_usage_liters ?? 0,
                'Energy' => $baseline->energy_usage_kwh ?? 0,
                'Waste' => $baseline->waste_generated_kg ?? 0,
                default => 0
            };

            $savedValue = $actions->where('domain', $domain)->sum('amount_saved');
            $percentage = ($baselineValue > 0) ? ($savedValue / $baselineValue) * 100 : 0;

            // Determine Medal
            $medal = 'Bronze'; // active domain
            if ($percentage >= $thresholds['gold']) {
                $medal = 'Gold';
            } elseif ($percentage >= $thresholds['silver']) {
                $medal = 'Silver';
            }

            // Store domain results
            $performance[$domain] = [
                'baseline'   => $baselineValue,
                'saved'      => $savedValue,
                'percentage' => round($percentage, 2),
                'medal'      => $medal,
            ];

            $totalPercentage += $percentage;
            $count++;
        }

        $average = $count > 0 ? $totalPercentage / $count : 0;
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
    
    
       // -------------------------------
    // STUDENT PERFORMANCE CALCULATION
    // -------------------------------
    
public function showStudentPerformance($studentId)
{
    // Load student with section → class → school → baseline
    $student = Student::with(['section.class.school.baseline'])->findOrFail($studentId);

    if (
        !$student->section ||
        !$student->section->class ||
        !$student->section->class->school->baseline
    ) {
        return back()->with('error', 'Baseline data not found for this student.');
    }

    $baseline = $student->section->class->school->baseline;

    // Get the corresponding user record
    $getStudentUser = User::where('student_id', $student->id)->first();

    if (!$getStudentUser) {
        return back()->with('error', 'User record not found for this student.');
    }

    // Performance domains
    $domains = [
        'Water' => ['silver' => 10, 'gold' => 20],
        'Energy' => ['silver' => 8, 'gold' => 15],
        'Waste' => ['silver' => 10, 'gold' => 25],
    ];

    // Fetch student actions (based on user’s student_id and section)
    $actions = StudentAction::where('user_id', $getStudentUser->id)
        ->where('section_id', $student->section_id)
        ->get();

    $domainPerformances = [];
    $totalPercentage = 0;
    $count = 0;

    foreach ($domains as $domain => $thresholds) {
        $baselineValue = match ($domain) {
            'Water' => $baseline->water_usage_liters ?? 0,
            'Energy' => $baseline->energy_usage_kwh ?? 0,
            'Waste' => $baseline->waste_generated_kg ?? 0,
            default => 0 
        };


        $savedValue = $actions->where('domain', $domain)->sum('amount_saved');
        $percentage = ($baselineValue > 0) ? ($savedValue / $baselineValue) * 100 : 0;

        $domainPerformances[] = [
            'domain' => $domain,
            'saved' => $savedValue,
            'percentage' => round($percentage, 2)
        ];

        $totalPercentage += $percentage;
        $count++;
    }

    // Calculate average performance
    $averagePerformance = $count > 0 ? $totalPercentage / $count : 0;

    // Assign medal type
    $finalMedal = $averagePerformance >= 20 ? 'Gold' : ($averagePerformance >= 10 ? 'Silver' : 'Bronze');

    // ✅ (Optional) Save the performance in `medals` table if needed
    Medal::updateOrCreate(
        ['student_id' => $student->id],
        [
            'school_id' => $student->section->class->school_id,
            'class_id' => $student->section->class_id,
            'section_id' => $student->section_id,
            'medal_type' => $finalMedal,
            'performance_percentage' => round($averagePerformance, 2)
        ]
    );

    return view('school.performance.student', compact(
        'student',
        'domainPerformances',
        'averagePerformance',
        'finalMedal'
    ));
}

   
}
