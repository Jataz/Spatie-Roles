<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle role-based access control.
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->withErrors('You need to log in first.');
        }

        // Fetch role from session or Spatie roles
        //$userRoles = session('role') ?? Auth::user()->getRoleNames()->toArray();
        $userRoles = session('role') ?? Auth::user()->roles->pluck('name')->toArray();

        if ($role && !in_array($role, (array) $userRoles)) {
            // If a specific role is required and user doesn't have it
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
