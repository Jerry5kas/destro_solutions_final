<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enrollments = $user->enrollments()->with('training')->latest()->take(5)->get();
        
        return view('user.dashboard.index', compact('user', 'enrollments'));
    }

    public function enrollments()
    {
        $user = Auth::user();
        $enrollments = $user->enrollments()->with('training')->latest()->get();
        
        return view('user.dashboard.enrollments', compact('user', 'enrollments'));
    }

    public function payments()
    {
        $user = Auth::user();
        $payments = $user->payments()->with('enrollment')->latest()->get();
        
        return view('user.dashboard.payments', compact('user', 'payments'));
    }
}
