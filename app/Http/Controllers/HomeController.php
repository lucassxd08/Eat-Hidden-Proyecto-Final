<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $stats = [
                'ingresos_hoy' => Order::whereDate('created_at', today())->sum('total'),
                'pendientes'   => Order::where('status', 'pending')->count(),
                'preparando'   => Order::where('status', 'preparing')->count(),
                'listos'       => Order::where('status', 'ready')->count(),
            ];
            $pedidos_recientes = Order::with('client', 'items.dish')->latest()->take(5)->get();
            return view('dashboard', compact('stats', 'pedidos_recientes'));
        }

        $restaurants = Restaurant::where('active', true)->withCount('dishes')->take(6)->get();
        return view('home', compact('restaurants'));
    }

    public function menu()
    {
        $restaurants = Restaurant::where('active', true)->withCount('dishes')->get();
        return view('menu', compact('restaurants'));
    }

    public function about()
    {
        return view('about');
    }
}
