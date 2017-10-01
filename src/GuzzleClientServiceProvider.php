<?php
declare(strict_types=1);

namespace Dpc\GuzzleClient;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class GuzzleClientServiceProvider extends ServiceProvider
{
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
    public function register(): void
    {
        $this->app->bind(RequestClientContract::class, GuzzleClient::class);
        $this->app->bind(Client::class, function () {
            return new Client([
                'base_uri' => config('guzzle.base_uri'),
            ]);
        });
    }
}
