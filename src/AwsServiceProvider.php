<?php namespace Aws\Laravel;

use Aws\Sdk;
use Illuminate\Support\ServiceProvider;

/**
 * AWS SDK for PHP service provider for Laravel applications
 */
class AwsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $config = realpath(__DIR__ . '/../config/config.php');

        $this->mergeConfigFrom($config, 'aws');

        $this->publishes([
            $config => $this->app->make('path.config') . DIRECTORY_SEPARATOR . 'aws.php'
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('aws', function ($app) {
            return new Sdk($app['config']->get('aws'));
        });

        $this->app->alias('aws', 'Aws\Sdk');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['aws', 'Aws\Common\Aws'];
    }

}
