<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        // If admin is already logged in, redirect them
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard')->with('info', 'You are logged in as admin. Please use the admin panel.');
        }
        
        // If regular user is already logged in, redirect to dashboard
        if (Auth::check() && !Auth::user()->is_admin) {
            return redirect()->route('user.dashboard');
        }
        
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if user is admin - prevent admins from logging in as users
            if (Auth::user()->is_admin) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Admin credentials cannot be used here. Please use the admin login page.'
                ])->onlyInput('email');
            }

            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors([ 'email' => 'The provided credentials do not match our records.' ])->onlyInput('email');
    }
}
