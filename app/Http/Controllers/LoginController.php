<?php

namespace App\Http\Controllers;

use App\Models\LdapUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle Active Directory login.
     */
    public function login(Request $request)
    {
        // Validate the user input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        try {
            // Authenticate the user via LDAP
            $ldapUser = LdapUser::authenticate($credentials['username'], $credentials['password']);

            if ($ldapUser) {
                // Log LDAP user authentication success
                Log::info("LDAP authentication successful for username: " . $credentials['username']);

                // Check if the user exists in the local database
                $localUser = User::where('username', $credentials['username'])->first();

                if (!$localUser) {
                    // If the user doesn't exist, create a new user in the local database
                    Log::info("User not found in local database, creating new user...");
                    $localUser = User::create([
                        'username' => $credentials['username'],
                    ]);
                } else {
                    Log::info("User found in local database: " . $localUser->username);
                }

                // Log the user in locally
                Auth::login($localUser);

                // Redirect to the intended page (e.g., dashboard)
                return redirect()->intended('/home');
            }

            // Authentication failed
            return back()->withErrors(['Invalid credentials. Please try again.']);
        } catch (\LdapRecord\Auth\BindException $e) {
            // Handle LDAP binding errors
            Log::error('LDAP Bind error: ' . $e->getMessage());
            return back()->withErrors(['LDAP bind error: ' . $e->getMessage()]);
        }
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
