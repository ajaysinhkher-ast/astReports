<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;
use Illuminate\Support\Facades\URL;
use App\Events\FetchShopifyOrdersEvent;
class HomeController extends Controller
{
    public function index()
    {
        $shop = Auth::user();

        $shopDomain  = $shop->name;
        $accessToken = $shop->password;
    
        FetchShopifyOrdersEvent::dispatch($shopDomain,$accessToken);

        Artisan::call('shopify:fetch-orders', [
            'shop' => $shopDomain,
            'accessToken' => $accessToken,
        ]);

        $orderUrl = URL::tokenRoute('order');

        return Inertia::render('welcome', [
            'greeting' => 'Hello Developer!',
            'orderUrl' => $orderUrl,
        ]);
    }

    public function order(){
        return Inertia::render('order');
    }
}
