<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware_old
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
           if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Role check
        if ($role === 'admin' && $user->role_id != 1) {
            return redirect()->route('student.dashboard');
        }
 
        if ($role === 'student' && $user->role_id != 2) {
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
