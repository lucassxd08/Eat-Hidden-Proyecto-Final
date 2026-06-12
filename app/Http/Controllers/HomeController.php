<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('active', true)->get();
        $featuredDishes = Dish::where('available', true)->with('category')->take(6)->get();

        return view('home', compact('categories', 'featuredDishes'));
    }

    public function menu()
    {
        $categories = Category::where('active', true)->with(['dishes' => function ($q) {
            $q->where('available', true);
        }])->get();

        return view('menu', compact('categories'));
    }

    public function about()
    {
        return view('about');
    }
}
