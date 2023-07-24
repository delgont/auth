<?php

namespace Delgont\Auth;

use Illuminate\Support\ServiceProvider;

use Illuminate\Routing\Router;


use Delgont\Auth\Concerns\RegistersCommands;

use Delgont\Auth\Http\Middleware\PermissionMiddleware;
use Delgont\Auth\Http\Middleware\RoleMiddleware;
use Delgont\Auth\Http\Middleware\UserTypeMiddleware;
use Delgont\Auth\Http\Middleware\PermissionViaSingleRole;

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\Facades\Blade;


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
            __DIR__.'/../config/multiauth.php' => config_path('multiauth.php'),
            __DIR__.'/../config/permissions.php' => config_path('permissions.php'),
            __DIR__.'/../config/roles.php' => config_path('roles.php')

        ], 'multiauth-config');

        $router = $this->app->make(Router::class);
        
        $router->aliasMiddleware('permission', PermissionMiddleware::class);
        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('permissionViaSingleRole', PermissionViaSingleRole::class);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerBladeExtensions();

        
        Blade::directive('role', function ($arguments) {
            list($role, $guard) = explode(',', $arguments.',');
            return "<?php if(auth({$guard})->check() && auth({$guard})->user()->hasRole({$role})): ?>";
        });

        Blade::directive('elserole', function ($arguments) {
            list($role, $guard) = explode(',', $arguments.',');

            return "<?php elseif(auth({$guard})->check() && auth({$guard})->user()->hasRole({$role})): ?>";
        });

        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });

    }


    protected function registerBladeExtensions()
    {
        
    }

  
}
