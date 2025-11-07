<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access the admin panel.');
        }

        if (!auth()->user()->is_admin) {
            // Regular users should be redirected to their dashboard, not shown 403
            return redirect()->route('user.dashboard')->with('error', 'You do not have admin privileges. Please use the user dashboard.');
        }

        return $next($request);
    }
}
