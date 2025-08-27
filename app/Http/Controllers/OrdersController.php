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
        // dd($query);
        $query = QueryFilter::apply($query, $request);
        $orders = $query->get();

        return Inertia::render('orders/Orders', [
            'orders' => $orders,
        ]);
    }

    public function filter(Request $request)
    {
        $queryJson = json_decode($request->input('query'), true);

        $query = Order::query();

        if ($queryJson && isset($queryJson['rules'])) {
            $combinator = strtolower($queryJson['combinator'] ?? 'and');

            $query->where(function ($q) use ($queryJson, $combinator) {
                foreach ($queryJson['rules'] as $rule) {
                    if (isset($rule['field'], $rule['operator'], $rule['value'])) {
                        if ($combinator === 'and') {
                            $q->where($rule['field'], $rule['operator'], $rule['value']);

                        } elseif ($combinator === 'or') {
                            $q->orWhere($rule['field'], $rule['operator'], $rule['value']);
                        }
                    }
                }
            });
        }
        // dd($query->toSql(), $query->getBindings());

        $orders = $query->get();
        // dd($orders);

        return Inertia::render('orders/Orders', [
            'orders' => $orders,
        ]); 
    }

    public function orderItems()
    {
        $orderItems = OrderItem::all();
        return Inertia::render('orders/OrderItems', [
            'orderItems' => $orderItems,
        ]);
    }
}
