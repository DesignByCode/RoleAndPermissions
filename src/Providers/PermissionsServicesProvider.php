<?php

namespace Designbycode\RolesAndPermissions\Providers;

use Designbycode\RolesAndPermissions\Models\Permission;
use Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class PermissionsServicesProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Permission::get()->map(function ($permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasPermissionsTo($permission);
            });
        });        

        // Role::get()->map(function ($role) {
        //     Gate::define($role->name, function ($user) use ($role) {
        //         return $user->hasRole($role);
        //     });
        // });

        Blade::directive('role', function ($role) {
            return "<?php if (auth()->check() && auth()->user()->hasRole({$role}) ):  ?>";
        });

        Blade::directive('endrole', function ($role) {
            return "<?php endif; ?>";
        });


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
