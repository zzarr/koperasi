<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || !$request->user()->hasRole($role)) {
            throw UnauthorizedException::forRoles([$role]);
        }

        return $next($request);
    }
}
