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
        \Log::info('RoleMiddleware: raw $role parameter', ['role' => $role]);

        if (!auth()->check()) {
            \Log::warning('RoleMiddleware: User not authenticated');
            abort(403, 'Unauthorized');
        }
        

        $roles = array_map(function($r) {
            \Log::info('RoleMiddleware: role value', ['r' => $r]);
            return strtolower(trim($r));
        }, explode(',', $role));
        $userRole = strtolower(trim(auth()->user()->role));
        \Log::info('RoleMiddleware: Checking user role', [
            'user_id' => auth()->user()->id,
            'user_role' => $userRole,
            'allowed_roles' => $roles
        ]);
        if (!in_array($userRole, $roles)) {
            \Log::warning('RoleMiddleware: Access denied', [
                'user_id' => auth()->user()->id,
                'user_role' => $userRole,
                'allowed_roles' => $roles
            ]);
            abort(403, 'Unauthorized. Your role: ' . auth()->user()->role);
        }
        \Log::info('RoleMiddleware: Access granted', [
            'user_id' => auth()->user()->id,
            'user_role' => $userRole,
            'allowed_roles' => $roles
        ]);
        return $next($request);
    }
}
