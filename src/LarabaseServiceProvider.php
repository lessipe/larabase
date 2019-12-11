<?php


namespace Lessipe\Larabase;

use Illuminate\Support\ServiceProvider;
use Lessipe\Larabase\Commands\ExceptionCommand;
use Lessipe\Larabase\Commands\JobCommand;
use Lessipe\Larabase\Commands\ModelCommand;
use Lessipe\Larabase\Commands\PolicyCommand;
use Lessipe\Larabase\Commands\PresenterCommand;
use Lessipe\Larabase\Commands\ServiceCommand;
use Lessipe\Larabase\Commands\ValidatorCommand;
use Lessipe\Larabase\Generators\ModelGenerator;

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
        $this->commands(ExceptionCommand::class);
        $this->commands(JobCommand::class);
        $this->commands(PolicyCommand::class);
        $this->commands(PresenterCommand::class);
        $this->commands(ServiceCommand::class);
        $this->commands(ValidatorCommand::class);
        $this->commands(ModelCommand::class);
    }
}
