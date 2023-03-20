<?php

namespace Delgont\Auth\Http\Middleware;

use Closure;

use Delgont\Auth\Exceptions\UnauthorizedException;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $guard = null)
    {
        $authenticated = app('auth')->guard($guard);

        if ($authenticated->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
        ? $permission
        : explode('|', $permission);

    foreach ($permissions as $permission) {
        if ($authenticated->user()->hasPermissionTo($permission)) {
            return $next($request);
        }
    }

    throw UnauthorizedException::forPermissions($permissions);

        
    }
}
