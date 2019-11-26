<?php


namespace Lessipe\Larabase;

use Illuminate\Support\ServiceProvider;

class LarabaseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/larabase.php' => config_path('larabase.php')
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    public function register()
    {
        $this->commands();
    }
}
