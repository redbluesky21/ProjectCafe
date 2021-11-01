<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-users', function ($user) {
            return $user->hasRole(['admin']);
        });
        Gate::define('manage-pos', function ($user) {
            return $user->hasAnyRoles(['admin','pelayan']);
        });
        Gate::define('manage-koki', function ($user) {
            return $user->hasAnyRoles(['admin','chef']);
        });
        Gate::define('manage-kasir', function ($user) {
            return $user->hasAnyRoles(['admin','kasir']);
        });

        Gate::define('pelayan-users', function ($user) {
            return $user->hasAnyRoles(['pelayan']);
        });

        Gate::define('edit-users', function ($user) {
            return $user->hasAnyRoles(['admin', 'pelayan']);
        });

        Gate::define('delete-users', function ($user) {
            return $user->hasRole('admin');
        });
    }
}
