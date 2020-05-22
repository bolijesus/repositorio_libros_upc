<?php

namespace App\Providers;

use App\Libro;
use App\Policies\UserPolicy;
use App\Revista;
use App\User;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('editar-libros', function (User $user, Libro $libroUsuario) {
            return $user->isAdmin() || ($user->id == $libroUsuario->bibliografia->usuario->id);
        });
        Gate::define('editar-revistas', function (User $user, Revista $revistaUsuario) {
            return $user->isAdmin() || ($user->id == $revistaUsuario->bibliografia->usuario->id);
        });
    
    }
}
