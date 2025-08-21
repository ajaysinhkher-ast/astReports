<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        // dd("bmdb");
        $shop = Auth::user();
        $shopDomain  = $shop->name;
        $accessToken = $shop->password;
        // dd($shopDomain);
        // $accessToken = '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';
        // dd($shopDomain,$accessToken);

        Artisan::call('shopify:fetch-orders', [
            'shop' => $shopDomain,
            'accessToken' => $accessToken,
        ]);

         $output = Artisan::output();
         dd($output);

        return Inertia::render('welcome');
    }

    // public function index(){
    //     $shop = Auth::user();
    //     $storeDomain  = $shop->name;
    //     $accessToken = $shop->password;

    //     $response = Http::withHeaders([
    //         'X-Shopify-Access-Token' => $accessToken,
    //     ])->get("https://{$storeDomain}/admin/api/2025-01/orders.json", [
    //         'status' => 'any',
    //         'limit' => 10,
    //     ]);

    //     if ($response->successful()) {
    //         $orders = $response->json()['orders'];
    //         return response()->json($orders);
    //     } else {
    //         return response()->json([
    //             'error' => $response->body(),
    //         ], $response->status());
    //     }

    //     return Inertia::render('welcome',['orders' => $orders]);
    // }
}
