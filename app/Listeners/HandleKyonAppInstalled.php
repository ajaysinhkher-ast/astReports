<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\FetchOrdersJob;
use Illuminate\Support\Facades\Log;
use Osiset\ShopifyApp\Messaging\Events\AppInstalledEvent;
use App\Models\User;

class HandleKyonAppInstalled
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppInstalledEvent $event): void
    {
        // dd($event);
       $shopId = $event->shopId->toNative();

        // fetch actual shop model
        $shop = User::findOrFail($shopId);
        // dd($shopId, $shop);

        $shopDomain = $shop->name;     // Shopify domain
        $accessToken = $shop->password; // API token
        // dd($shopId,$shop,$accessToken, $shopDomain);

        Log::info("Handling Kyon App Installed for shop: {$shopDomain}");

        FetchOrdersJob::dispatch($shopDomain, $accessToken);

    }
}
