<?php

namespace OneBiznet\Admin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::group($this->routeConfig(), function () {
                $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
            });
    }

    private function routeConfig()
    {
        return config('admin.route');
    }
}
