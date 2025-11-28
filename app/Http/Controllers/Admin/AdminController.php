<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\Contact;
use App\Models\ContentItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        // If admin is already logged in, redirect to dashboard
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        
        // If regular user is logged in, redirect them away
        if (Auth::check() && !Auth::user()->is_admin) {
            return redirect()->route('user.dashboard')->with('info', 'You are logged in as a regular user. Please use the user dashboard.');
        }
        
        return view('admin.login');
    }

    /**
     * Handle admin login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if user is admin - prevent regular users from logging in as admin
            if (!Auth::user()->is_admin) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['These credentials do not have admin access. Please use the user login page.'],
                ]);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        // Get date ranges
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();
        $last12Months = $now->copy()->subMonths(12);
        $last6Months = $now->copy()->subMonths(6);
        $lastWeek = $now->copy()->subWeek();
        
        // Revenue: Total from successful payments (last 12 months)
        $totalRevenue = Payment::where('status', 'succeeded')
            ->where('created_at', '>=', $last12Months)
            ->sum('amount');
        
        // Previous period for comparison
        $previousRevenue = Payment::where('status', 'succeeded')
            ->whereBetween('created_at', [$last12Months->copy()->subMonths(12), $last12Months])
            ->sum('amount');
        
        $revenueGrowth = $previousRevenue > 0 
            ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 
            : 0;
        
        // Revenue by month (last 12 months) for chart
        $revenueChartData = [];
        $previousRevenueChartData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $startOfMonth = $now->copy()->subMonths($i)->startOfMonth();
            $endOfMonth = $now->copy()->subMonths($i)->endOfMonth();
            
            $revenue = Payment::where('status', 'succeeded')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount');
            $revenueChartData[] = (float) $revenue;
            
            // Previous period (12 months before)
            $prevStartOfMonth = $startOfMonth->copy()->subMonths(12);
            $prevEndOfMonth = $endOfMonth->copy()->subMonths(12);
            
            $prevRevenue = Payment::where('status', 'succeeded')
                ->whereBetween('created_at', [$prevStartOfMonth, $prevEndOfMonth])
                ->sum('amount');
            $previousRevenueChartData[] = (float) $prevRevenue;
        }
        
        // Order Time Distribution: Enrollments by time of day (last 6 months)
        $enrollmentsByTime = Enrollment::where('created_at', '>=', $last6Months)
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->pluck('count', 'hour')
            ->toArray();
        
        // Categorize into Morning (6-12), Afternoon (12-18), Evening (18-24)
        $morningCount = 0;
        $afternoonCount = 0;
        $eveningCount = 0;
        
        foreach ($enrollmentsByTime as $hour => $count) {
            if ($hour >= 6 && $hour < 12) {
                $morningCount += $count;
            } elseif ($hour >= 12 && $hour < 18) {
                $afternoonCount += $count;
            } elseif ($hour >= 18 || $hour < 6) {
                $eveningCount += $count;
            }
        }
        
        $totalTimeCount = $morningCount + $afternoonCount + $eveningCount;
        $morningPercent = $totalTimeCount > 0 ? round(($morningCount / $totalTimeCount) * 100) : 0;
        $afternoonPercent = $totalTimeCount > 0 ? round(($afternoonCount / $totalTimeCount) * 100) : 0;
        $eveningPercent = $totalTimeCount > 0 ? round(($eveningCount / $totalTimeCount) * 100) : 0;
        
        // Rating metrics: Content Items, Users, Contacts
        $activeContentItems = ContentItem::where('status', 'active')->count();
        $totalContentItems = ContentItem::count();
        $contentItemPercentage = $totalContentItems > 0 ? round(($activeContentItems / $totalContentItems) * 100) : 0;
        
        $activeUsers = User::where('is_admin', false)->whereNotNull('email_verified_at')->count();
        $totalUsers = User::where('is_admin', false)->count();
        $userPercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;
        
        $readContacts = Contact::whereIn('status', ['read', 'active'])->count();
        $totalContacts = Contact::count();
        $contactPercentage = $totalContacts > 0 ? round(($readContacts / $totalContacts) * 100) : 0;
        
        // Most Popular Services/Trainings: Top content items by enrollment count
        $popularItems = ContentItem::where('type', 'training')
            ->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->title,
                    'enrollments_count' => $item->enrollments_count,
                    'price' => $item->price ?? 0,
                    'formatted_price' => $item->formatted_price ?? '$0',
                ];
            });
        
        // Total Orders: Total enrollments
        $totalOrders = Enrollment::where('created_at', '>=', $last6Months)->count();
        
        // Previous period for comparison (6 months before the last 6 months period)
        $previousPeriodStart = $last6Months->copy()->subMonths(6);
        $previousOrders = Enrollment::whereBetween('created_at', [$previousPeriodStart, $last6Months])
            ->count();
        
        $ordersGrowth = $previousOrders > 0 
            ? (($totalOrders - $previousOrders) / $previousOrders) * 100 
            : 0;
        
        // Orders by month for chart (last 6 months)
        $ordersChartData = [];
        $previousOrdersChartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $startOfMonth = $now->copy()->subMonths($i)->startOfMonth();
            $endOfMonth = $now->copy()->subMonths($i)->endOfMonth();
            
            $orders = Enrollment::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
            $ordersChartData[] = $orders;
            
            // Previous period (6 months before)
            $prevStartOfMonth = $startOfMonth->copy()->subMonths(6);
            $prevEndOfMonth = $endOfMonth->copy()->subMonths(6);
            
            $prevOrders = Enrollment::whereBetween('created_at', [$prevStartOfMonth, $prevEndOfMonth])
                ->count();
            $previousOrdersChartData[] = $prevOrders;
        }
        
        return view('admin.dashboard', [
            'totalRevenue' => $totalRevenue,
            'revenueGrowth' => $revenueGrowth,
            'revenueChartData' => $revenueChartData,
            'previousRevenueChartData' => $previousRevenueChartData,
            'morningPercent' => $morningPercent,
            'afternoonPercent' => $afternoonPercent,
            'eveningPercent' => $eveningPercent,
            'contentItemPercentage' => $contentItemPercentage,
            'userPercentage' => $userPercentage,
            'contactPercentage' => $contactPercentage,
            'popularItems' => $popularItems,
            'totalOrders' => $totalOrders,
            'ordersGrowth' => $ordersGrowth,
            'ordersChartData' => $ordersChartData,
            'previousOrdersChartData' => $previousOrdersChartData,
            'last12MonthsStart' => $last12Months->format('M, Y'),
            'last6MonthsStart' => $last6Months->format('M, Y'),
        ]);
    }

    /**
     * Placeholder methods for other admin pages
     */
    public function services()
    {
        return view('admin.services');
    }

    public function products()
    {
        return view('admin.products');
    }

    public function reviews()
    {
        return view('admin.reviews');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function payment()
    {
        return view('admin.payment');
    }

    public function accounts()
    {
        return view('admin.accounts');
    }

    public function help()
    {
        return view('admin.help');
    }
}
