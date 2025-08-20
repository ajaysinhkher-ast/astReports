<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('welcome');
    }

    public function order(){
        return Inertia::render('order');
    }
}
