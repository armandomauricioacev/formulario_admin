<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:superadmin') or ->middleware('role:admin,superadmin')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        // Normalize roles array (allow comma-separated string or multiple params)
        if (count($roles) === 1 && str_contains((string) $roles[0], ',')) {
            $roles = array_map(fn ($r) => trim($r), explode(',', (string) $roles[0]));
        }

        if (empty($roles)) {
            // If no roles provided, deny access
            abort(403);
        }

        if (!in_array($user->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}