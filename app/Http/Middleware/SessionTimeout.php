<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $timeout = config('session.lifetime') * 60; // Convert minutes to seconds
            $lastActivity = session('lastActivityTime');

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                Auth::logout(); // Log out the user
                session()->flush(); // Clear all session data

                return redirect()->route('login')->with('message', 'You have been logged out due to inactivity.');
            }

            session(['lastActivityTime' => time()]); // Update last activity timestamp
        }

        return $next($request);
    }
}
