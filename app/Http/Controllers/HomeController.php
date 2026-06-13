<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;

class HomeController extends Controller
{
    public function index()
    {
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
