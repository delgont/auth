<?php

namespace Delgont\Auth\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
  
    public static function forPermissions(array $permissions): self
    {
        $message = 'You do not have the right permissions to access this resource.';

        if (config('permission.display_permission_in_exception', true)) {
            $permStr = implode(', ', $permissions);
            $message = $message.' Necessary permissions are '.$permStr;
        }

        $exception = new static(403, $message, null, []);
        $exception->requiredPermissions = $permissions;

        return $exception;
    }

    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }

}
