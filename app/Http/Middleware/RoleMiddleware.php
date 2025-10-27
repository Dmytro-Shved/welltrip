<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! auth()->check()) {
            // Not logged in
            abort(401);
        }

        if (! auth()->user()->roles()->where('name', $role)->exists()) {
            // Logged in, but doesn't have permissions
            abort(403);
        }

        return $next($request);
    }
}
