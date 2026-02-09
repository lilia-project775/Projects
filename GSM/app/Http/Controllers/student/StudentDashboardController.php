<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAction;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Logged-in user's ID (from users table)
        $userId = Auth::id();
        // Fetch total saved amount by domain for this user
        $waterTotal = StudentAction::where('user_id', $userId)->where('domain', 'Water')->sum('amount_saved');
        $energyTotal = StudentAction::where('user_id', $userId)->where('domain', 'Energy')->sum('amount_saved');
        $wasteTotal = StudentAction::where('user_id', $userId)->where('domain', 'Waste')->sum('amount_saved');

        return view('student.dashboard', compact('waterTotal', 'energyTotal', 'wasteTotal'));
    }
    // public function index()
    // {
    //     // Logged-in user's ID (from users table)
    //     $userId = Auth::id();

    //     // fetch total saved amount by domain for this user
    //     $savings = StudentAction::where('user_id', $userId)
    //         ->selectRaw('domain, SUM(amount_saved) as total_saved')
    //         ->groupBy('domain')
    //         ->pluck('total_saved', 'domain')
    //         ->toArray();

    //     // Ensure all three domains exist even if missing
    //     $domains = ['Water', 'Waste', 'Energy'];
    //     $chartData = [];
    //     foreach ($domains as $domain) {
    //         $chartData[] = [
    //             'domain' => $domain,
    //             'amount' => $savings[$domain] ?? 0,
    //         ];
    //     }

    //     return view('student.dashboard', compact('chartData'));
    // }
}
