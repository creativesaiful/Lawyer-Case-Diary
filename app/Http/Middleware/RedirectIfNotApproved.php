<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
 
        // Check if the user is logged in and if their account is approved
        if (Auth::check() && !Auth::user()->approved) {
            
            // If not approved, redirect to a pending page
            return redirect()->route('approval.pending')->with('status', 'Your account is pending approval.');
        }

        return $next($request);
    }
}
