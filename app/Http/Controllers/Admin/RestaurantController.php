<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::withCount('dishes')->latest()->get();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        return view('admin.restaurants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'active'      => 'boolean',
        ]);

        Restaurant::create([
            'name'        => $request->name,
            'description' => $request->description,
            'active'      => $request->boolean('active', true),
        ]);

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurante creado correctamente.');
    }

    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'active'      => 'boolean',
        ]);

        $restaurant->update([
            'name'        => $request->name,
            'description' => $request->description,
            'active'      => $request->boolean('active'),
        ]);

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurante actualizado correctamente.');
    }

    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->dishes()->count() > 0) {
            return back()->with('error', 'No se puede eliminar un restaurante que tiene platos.');
        }

        $restaurant->delete();
        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurante eliminado.');
    }
}
