<?php

namespace App\Listeners;

use App\Events\FetchShopifyOrdersEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\ShopifyService;
class HandleFetchShopifyOrders implements ShouldQueue
{
    protected $shopifyService;

    public function __construct(ShopifyService $shopifyService)
    {
        $this->shopifyService = $shopifyService;
    }

    public function handle(FetchShopifyOrdersEvent $event)
    {
        $this->shopifyService->fetchOrder($event->shop, $event->accessToken);
    }




}