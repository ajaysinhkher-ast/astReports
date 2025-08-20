<?php

namespace App\Jobs;

use App\Services\ShopifyService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchShopifyOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected string $shopDomain;
    protected string $accessToken;
    protected int $shopId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $shopDomain, string $accessToken, int $shopId)
    {
        $this->shopDomain = $shopDomain;
        $this->accessToken = $accessToken;
        $this->shopId = $shopId;
    }

    /**
     * Execute the job.
     */
    public function handle(ShopifyService $shopifyService)
    {
          $shopifyService->fetchOrder($this->shopDomain, $this->accessToken, $this->shopId);
    }
}
