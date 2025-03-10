<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('login');
        }
        
        // Check if authenticated user has admin role
        if (!Auth::user()->hasRole('admin')) {
            // Return 403 Forbidden response
            abort(403);
        }
        
        // User is admin, proceed with request
        return $next($request);
    }
}
