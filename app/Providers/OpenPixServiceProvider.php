<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenPix\PhpSdk\Client;

class OpenPixServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client(
                env("OPENPIX_APP_ID"),
                env("OPENPIX_BASE_URI", "https://api.openpix.com.br")
            );
        });
    }
}
