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
        $allow = false;

        if ($authenticated->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
        ? $permission
        : explode(config('permissions.delimiter', '|'), $permission);

        foreach ($permissions as $permission) {
            $allow = ($authenticated->user()->hasPermissionTo($permission)) ? true : false;
        }

        if ($allow) {
            # code...
            return $next($request);
        }

        throw UnauthorizedException::forPermissions($permissions);

        
    }
}
