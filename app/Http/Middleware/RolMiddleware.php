<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! in_array(auth()->user()->rol, $roles)) {
            abort(403, 'No autorizado para esta acción.');
        }

        return $next($request);
    }
}
