<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        config(['adminlte.menu' => array_merge(config('adminlte.menu', []), [
            ['text' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'bi bi-speedometer2'],
            ['text' => 'Data Project', 'route' => 'admin.projects.index', 'icon' => 'bi bi-folder'],
        ])]);

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
