<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Authorization is handled with Laravel Gates (Modul 6 standard).
     * Use @can('admin') / @can('user') in Blade and Gate::authorize('admin')
     * inside controllers — no custom middleware files.
     */
    public function boot(): void
    {
        Gate::define('admin', fn (User $user) => $user->role === 'admin');
        Gate::define('user', fn (User $user) => $user->role === 'user');
    }
}
