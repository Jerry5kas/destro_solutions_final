<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
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
        
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false, // Ensure new users are not admins
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Welcome! Your account has been created.');
    }
}
