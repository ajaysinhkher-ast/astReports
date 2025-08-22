<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderItem;

class OrdersController extends Controller
{
    public function orders(){
        $orders = Order::all();
        return Inertia::render('Orders', [
            'orders' => $orders,
        ]);
    }

    public function orderItems(){
        $orderItems=OrderItem::all();
        return Inertia::render('OrderItems', [
            'orderItems' => $orderItems,
        ]);
    }
}
