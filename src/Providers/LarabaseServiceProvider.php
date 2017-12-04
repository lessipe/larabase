<?php
namespace Lessipe\Larabase\Providers;

use Illuminate\Support\ServiceProvider;
use Lessipe\Larabase\Generators\Commands\ComposerCommand;
use Lessipe\Larabase\Generators\Commands\ExceptionCommand;
use Lessipe\Larabase\Generators\Commands\MailCommand;

/**
 * Class LarabaseServiceProvider
 * @package Lessipe\Larabase\Providers
 */
class LarabaseServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/larabase.php' => config_path('larabase.php')
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../../migrations');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(\Lessipe\Larabase\Generators\Commands\RepositoryCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\TransformerCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\PresenterCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\EntityCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\ValidatorCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\ControllerCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\BindingsCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\CriteriaCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\JobCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\ServiceCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\PolicyCommand::class);
        $this->commands(\Lessipe\Larabase\Generators\Commands\NotificationCommand::class);
        $this->commands(MailCommand::class);
        $this->commands(ComposerCommand::class);
        $this->commands(ExceptionCommand::class);
        $this->app->register('Lessipe\Larabase\Providers\EventServiceProvider');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
