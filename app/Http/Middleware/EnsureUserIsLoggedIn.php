<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in by checking the session
        if (!$request->session()->has('logged_in') || !$request->session()->get('logged_in')) {
            // User is not logged in - redirect to login demo page with message
            return redirect('/login-demo')->with('warning', 'You must be logged in to access this page.');
        }
        
        // User is logged in - allow request to continue to the controller
        return $next($request);
    }
}
