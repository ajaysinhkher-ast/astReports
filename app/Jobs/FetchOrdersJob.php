<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use App\Events\AppInstalledEvent;
use Illuminate\Support\Facades\Log;



class FetchOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public string $shopDomain;
    public string $accessToken;

    /**
     * Create a new job instance.
     */
    public function __construct(string $shopDomain, string $accessToken)
    {
        // dd($shopDomain, $accessToken);
        $this->shopDomain = $shopDomain;
        $this->accessToken = $accessToken;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('shopify:fetch-orders', [
            'shop' => $this->shopDomain,
            'accessToken' => $this->accessToken,
        ]);

        \Log::info('Shopify fetch-orders output: ' . Artisan::output());
    }
}
