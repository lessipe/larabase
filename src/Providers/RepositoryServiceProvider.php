<?php
namespace Visualplus\Larabase\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package Visualplus\Larabase\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
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
            __DIR__ . '/../../../config/larabase.php' => config_path('larabase.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../../config/larabase.php', 'repository');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Visualplus\Larabase\Generators\Commands\RepositoryCommand');
        $this->commands('Visualplus\Larabase\Generators\Commands\TransformerCommand');
        $this->commands('Visualplus\Larabase\Generators\Commands\PresenterCommand');
        $this->commands('Visualplus\Larabase\Generators\Commands\EntityCommand');
        $this->commands('Visualplus\Larabase\Generators\Commands\ValidatorCommand');
        $this->commands('Visualplus\Larabase\Generators\Commands\ControllerCommand');
        $this->commands('Visualplus\Larabase\Generators\Commands\BindingsCommand');
        $this->commands('Visualplus\Larabase\Generators\Commands\CriteriaCommand');
        $this->app->register('Visualplus\Larabase\Providers\EventServiceProvider');
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
