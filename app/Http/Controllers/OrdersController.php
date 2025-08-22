<?php

namespace App\Http\Controllers;

use App\Filter\QueryFilter;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function orders(Request $request)
    {
        $query = Order::query();
        $query = QueryFilter::apply($query, $request);
        $orders = $query->get();
        return Inertia::render('Orders', [
            'orders' => $orders,
            'title'=>$request->title,
        ]);
    }

    public function orderItems()
    {
        $orderItems = OrderItem::all();
        return Inertia::render('OrderItems', [
            'orderItems' => $orderItems,
        ]);
    }
}
