<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRolMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $allowed = [];
        foreach ($roles as $role) {
            foreach (explode(',', $role) as $r) {
                $allowed[] = trim($r);
            }
        }

        if (! $request->user() || ! in_array($request->user()->rol, $allowed)) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado para esta acción.',
            ], 403);
        }

        return $next($request);
    }
}
