<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{

    // login for.
    public function loginForm()
    {
        return view('auth.login');
    }

    // user login here
    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        $user = User::where('email', $request->email)->first();

        if ($user && Auth::attempt($credentials, $remember)) {
            if ($user->role_id == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role_id == 2) {
                return redirect()->route('student.dashboard');
            } elseif ($user->role_id == 3) {
                return redirect()->route('school.dashboard'); 
            } else {
                Auth::logout(); // prevent logging in unknown roles
                return back()->with('error', 'Unauthorized role.')->withInput();
            }
        }

        if ($user) {
            return back()->with('passwordError', 'The password you entered is incorrect.')->withInput();
        } else {
            return back()->with('emailError', 'No account found with this email address.')->withInput();
        }
    }


}
