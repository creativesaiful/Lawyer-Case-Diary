<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ChamberAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
   public function handle(Request $request, Closure $next): Response
{
    $caseDiary = $request->route('caseDiary');
    $date = $request->route('date');

    if ($caseDiary && Auth::check() && Auth::user()->chamber_id === $caseDiary->chamber_id) {
        return $next($request);
    }

    if ($date && Auth::check() && Auth::user()->chamber_id === $date->caseDiary->chamber_id) {
        return $next($request);
    }

    abort(403, 'Unauthorized access to this case.');
}

}
