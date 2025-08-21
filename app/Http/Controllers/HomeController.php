<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Osiset\ShopifyApp\Messaging\Events\AppInstalledEvent;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        // dd("bmdb");
        $shop = Auth::user();
        // $store_id = Auth::id();
        // dd($store_id);

        $shopDomain  = $shop->name;
        $accessToken = $shop->password;

        // dd($shopDomain);
        // $accessToken = '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';
        // dd($shopDomain,$accessToken);

        // Artisan::call('shopify:fetch-orders', [
        //     'shop' => $shopDomain,
        //     'accessToken' => $accessToken,
        //     // 'storeId'=> $store_id
        // ]);

        try{

            // AppInstalledEvent::dispatch($shopDomain, $accessToken);

        }catch(\Exception $e){
            // Handle the exception
            // Log::error('Error dispatching AppInstalledEvent: ' . $e->getMessage());
            return Inertia::render('Error', ['message' => 'Failed to dispatch event']);
        }

        // $output = Artisan::output();
        // dd($output);

        return Inertia::render('welcome');
    }

    public function order(Request $request)
    {
        // dd("data");
        $shop = Auth::user();
        // dd($shop);

        $shopDomain  = $shop->name;
        $accessToken = $shop->password;
        // dd($shopDomain, $accessToken);

        // fetch oders from the database:
        $orders = Order::all();

        
        return Inertia::render('orders',['orders'=>$orders]);
        // dd($orders);
    }
}


