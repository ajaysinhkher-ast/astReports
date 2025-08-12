<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $shop = Auth::user();

        $shopDomain  = $shop->name;
        $accessToken = $shop->password;
        // dd($shopDomain,$accessToken);

        Artisan::call('shopify:fetch-orders', [
            'shop' => $shopDomain,
            'accessToken' => $accessToken,
        ]);

         $output = Artisan::output();
         dd($output);

        return Inertia::render('welcome', [
            'greeting' => 'Hello Developer!',
        ]);
    }
}
