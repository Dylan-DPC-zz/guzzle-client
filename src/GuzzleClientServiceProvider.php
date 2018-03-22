<?php
declare(strict_types=1);

namespace Dpc\GuzzleClient;

use Illuminate\Support\ServiceProvider;

class GuzzleClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.;
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RequestInterface::class, Client::class);
    }
}
