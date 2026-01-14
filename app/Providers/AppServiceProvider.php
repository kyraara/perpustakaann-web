<?php

namespace App\Providers;

use App\Models\Pengaturan;
use Illuminate\Support\Facades\View;
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
     */
    public function boot(): void
    {
        // Share settings globally to all views
        View::composer('*', function ($view) {
            $view->with('setting', new class {
                public function __call($name, $arguments)
                {
                    $default = $arguments[0] ?? null;
                    return Pengaturan::getValue($name, $default);
                }
                
                public function get($key, $default = null)
                {
                    return Pengaturan::getValue($key, $default);
                }
            });
        });
    }
}

