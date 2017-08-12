<?php

namespace Dpc\GuzzleClient;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use ThemeAnorak\LaravelShopify\Services\GuzzleClient;

class GuzzleClientProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/guzzle.php' => config_path('guzzle.php'),
        ], 'config');

    }

    /**
     * Register any application services.;
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RequestClientContract::class, GuzzleClient::class);
        $this->app->bind(Client::class, function () {
            return new Client([
                'base_uri' => config('guzzle.base_uri'),
            ]);
        });

    }
}