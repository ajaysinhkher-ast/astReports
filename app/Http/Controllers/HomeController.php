<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Osiset\ShopifyApp\Messaging\Events\AppInstalledEvent;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('welcome');
    }

    public function order()
    {
    Log::info('inside oreder');
       $orders = Order::all();

       return Inertia::render('orders',['orders'=>$orders]);
    }

    public function test(){
        $orders = Order::all();

       return Inertia::render('dashboard');
    }
}
