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
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }
        $roles = array_map(function($r) { return strtolower(trim($r)); }, explode(',', $role));
        if (!in_array(strtolower(auth()->user()->role), $roles)) {
            // Debug: Show current user role on 403
            abort(403, 'Unauthorized. Your role: ' . auth()->user()->role);
        }
        return $next($request);
    }
}
