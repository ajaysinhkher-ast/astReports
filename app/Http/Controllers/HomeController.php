<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Osiset\ShopifyApp\Messaging\Events\AppInstalledEvent;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try{

        }catch(\Exception $e){
            return Inertia::render('Error', ['message' => 'Failed to dispatch event']);
        }
        return Inertia::render('welcome');
    }

    public function order(Request $request)
    {
       $orders = Order::all();
       
       return Inertia::render('orders',['orders'=>$orders]);
    }
}


