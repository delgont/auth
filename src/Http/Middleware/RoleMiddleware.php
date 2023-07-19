<?php

namespace Delgont\Auth\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
use Delgont\Auth\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role, $guard = null)
    {
        $authGuard = Auth::guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $roles = is_array($role) ? $role : explode('|', $role);

        
        if (!method_exists($authGuard->user(), 'hasAnyRole')) {
            if (! $authGuard->user()->hasRole($roles)) {
                abort(403, 'do  ot have role to access here');
            }
        }else{
            if (! $authGuard->user()->hasAnyRole($roles)) {
                throw UnauthorizedException::forRoles($roles);
            }
        }

        return $next($request);
    }
}
