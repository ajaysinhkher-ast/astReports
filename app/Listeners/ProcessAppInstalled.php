<?php

namespace App\Listeners;
use Illuminate\Contracts\Queue\ShouldQueue;
use Osiset\ShopifyApp\Messaging\Events\AppInstalledEvent;
use App\Models\User;
use App\Jobs\FetchShopifyOrders;

class ProcessAppInstalled implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AppInstalled  $event
     * @return void
     */
    public function handle(AppInstalledEvent $event)
    {
        $shopId=$event->shopId->toNative() ?? (string) $event->shopId;
        $shop=User::findOrFail($shopId);
        $shopDomain  = $shop->name;
        $accessToken = $shop->password;

        FetchShopifyOrders::dispatch($shopDomain,$accessToken,$shopId);
    }
}