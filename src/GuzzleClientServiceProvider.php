<?php

namespace Dpc\GuzzleClient;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class GuzzleClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config.php' => config_path('guzzle.php'),
        ], 'guzzle-client-config');
    }

    /**
     * Register any application services.;
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RequestClientContract::class, GuzzleClient::class);
        $this->app->bind(ClientInterface::class, function () {
            return new Client([
                'base_uri' => config('guzzle.base_uri'),
            ]);
        });
    }
}
