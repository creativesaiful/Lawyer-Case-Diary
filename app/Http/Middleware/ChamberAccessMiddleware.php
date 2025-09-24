<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChamberAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        
        $caseId = $request->route('case');

        if ($caseId) {
            $case = \App\Models\CaseDiary::findOrFail($caseId);
            if ($case->chamber_id !== auth()->user()->chamber_id && !auth()->user()->isAdmin()) {
                return abort(403, 'Unauthorized access to this case.');
            }
        }

        return $next($request);
    }
}