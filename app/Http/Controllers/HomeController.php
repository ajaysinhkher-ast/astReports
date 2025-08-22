<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('welcome');
    }

}
