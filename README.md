
## Laravel Auth

### Introduction
Authentication is pretty much easier with laravel via traditional login forms, what about Multi Username authention, access control using roles and permissions.

#### # Requirements
`Composer` `Laravel Framework 6.0+`

---

### Multi Authentication

`Login Controller`

```php
<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Delgont\Auth\Concerns\MultiAuthCredentials;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller - Multi Authentication using email or username
    |--------------------------------------------------------------------------
    | Use Delgont\Auth\Concerns\MultiAuthCredentials trait
    | You must override the credentials and username functions as shown below
    |
    */
    use AuthenticatesUsers, MultiAuthCredentials;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        return $this->multiAuthCredentials($request);
    }

    public function username()
    {
        return 'username_email';
    }
}
```

`Login Form Username Or Email Input`

```php
<input id="username_email" type="text" class="form-control @error('username_email') is-invalid @enderror" name="username_email" value="{{ old('username_email') }}" required autocomplete="username_email" autofocus>
@error('username_email')
  <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
  </span>
@enderror
```

---

### Access Protection

##### 1. Access Protection Via Roles


`Using role middleware to restrict access`

Use `Delgont\Auth\Concerns\ModelHasRoles` trait on your authenticable model

```php
<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Delgont\Cms\Notifications\Auth\ResetPassword as ResetPasswordNotification;

use Delgont\Auth\Concerns\ModelHasRoles;



class User extends Authenticatable
{
    /*
    | Use Delgont\Auth\Concerns\ModelHasRoles trait
    |
    */
    use ModelHasRoles;


}

```

```php
Route::get('/test', 'TestController@test')->middleware('role:hello');
```


`Using permission middleware to restrict access`

```php
Route::get('/momo', 'Momo@index')->name('momo')->middleware('permission:access_momo_dashboard');
```

`Configure your default permissions in the permissions configuration file`

`
<?php

return [
    'delimiter' => '|',

    'permissions' => [
      'manage_users',
      'access_momo_dashbaord'
    ]
];
`

`Generate or store your default permissions in the DB`
```php
php artisan generate:permissions
```

`User Model` - add `Delgont\Auth\Models\Concerns\HasPermissions` trait
```php
<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Delgont\Auth\Models\Concerns\HasPermissions;

class User extends Authenticatable
{
    use HasPermissions;
}
```
`Giving permission to user`

```php
// Adding permissions to a user
$user->givePermissionTo('manage_users');
```