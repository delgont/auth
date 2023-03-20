<?php

namespace Delgont\Auth\Concerns;

use Illuminate\Http\Request;

trait MultiAuthCredentials
{
     /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function multiAuthCredentials(Request $request)
    {
        $username = filter_var($request->{method_exists($this, 'username') ? $this->username() : 'email'}, FILTER_VALIDATE_EMAIL) ? 'email' : config('auth.username', 'name');

        return [
         $username => $request->{method_exists($this, 'username') ? $this->username() : 'email'},
         'password' => $request->password
        ];
    }
    
}
