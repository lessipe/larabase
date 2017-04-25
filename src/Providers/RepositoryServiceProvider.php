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
            __DIR__ . '/../../config/larabase.php' => config_path('larabase.php')
        ]);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(\Visualplus\Larabase\Generators\Commands\RepositoryCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\TransformerCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\PresenterCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\EntityCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\ValidatorCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\ControllerCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\BindingsCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\CriteriaCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\ActionCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\JobCommand::class);
        $this->commands(\Visualplus\Larabase\Generators\Commands\ServiceCommand::class);
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
