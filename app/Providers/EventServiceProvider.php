<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\AppInstalledEvent;
use Osiset\ShopifyApp\Messaging\Events\AppInstalled;
use App\Listeners\HandleKyonAppInstalled;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    // protected $listen = [
    //     // Kyon's AppInstalled event
    //         AppInstalled::class => [
    //         HandleKyonAppInstalled::class,
    //         Log::info('eventlistener registered for shop: ')
    //     ],
    // ];
}
