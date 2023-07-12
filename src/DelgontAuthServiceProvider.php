<?php

namespace Delgont\Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

use Delgont\Auth\Http\Middleware\Permission;

use Delgont\Auth\Concerns\RegistersCommands;

use Delgont\Auth\Http\Middleware\UserTypeMiddleware;


class DelgontAuthServiceProvider extends ServiceProvider
{
    use RegistersCommands;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app('router')->aliasMiddleware('usertype', UserTypeMiddleware::class);

        $this->registerCommands();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/multiauth.php' => config_path('multiauth.php')
        ], 'multiauth-config');

        $this->publishes([
            __DIR__.'/../config/permissions.php' => config_path('permissions.php')
        ], 'permissions-config');

        $router = $this->app->make(Router::class);
        
        $router->aliasMiddleware('permission', Permission::class);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }

  
}
