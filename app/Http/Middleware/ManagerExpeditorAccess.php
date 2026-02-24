<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerExpeditorAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }
        $allowedRoles = ['Manager', 'Expeditor', 'Supplier'];
        if (!in_array(auth()->user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
