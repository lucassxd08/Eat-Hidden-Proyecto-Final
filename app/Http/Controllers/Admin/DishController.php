<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::with('category', 'restaurant')->orderBy('name')->get();
        return view('admin.dishes.index', compact('dishes'));
    }

    public function create()
    {
        $categories  = Category::where('active', true)->orderBy('name')->get();
        $restaurants = Restaurant::where('active', true)->orderBy('name')->get();
        return view('admin.dishes.create', compact('categories', 'restaurants'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'category_id'   => 'nullable|exists:categories,id',
            'new_category'  => 'nullable|string|max:100',
            'name'          => 'required|string|max:150',
            'description'   => 'nullable|string|max:500',
            'price'         => 'required|numeric|min:0',
            'image'         => 'nullable|image|max:2048',
            'available'     => 'boolean',
        ]);

        if (empty($data['category_id']) && empty($request->new_category)) {
            return back()->with('error', 'Debes seleccionar una categoría o escribir una nueva.')->withInput();
        }

        try {
            if ($request->filled('new_category')) {
                $category = Category::firstOrCreate(
                    ['name' => trim($request->new_category)],
                    ['active' => true]
                );
                $data['category_id'] = $category->id;
            }

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('dishes', 'public');
            }

            unset($data['new_category']);
            $data['available'] = $request->boolean('available', true);
            Dish::create($data);

            if ($request->filled('back_to_restaurant')) {
                return redirect()->route('admin.restaurants.show', $request->back_to_restaurant)
                    ->with('success', 'Plato añadido correctamente.');
            }

            return redirect()->route('admin.dishes.index')->with('success', 'Plato creado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo crear el plato. Intente nuevamente.')->withInput();
        }
    }

    public function edit(Dish $dish)
    {
        $categories  = Category::where('active', true)->orderBy('name')->get();
        $restaurants = Restaurant::where('active', true)->orderBy('name')->get();
        return view('admin.dishes.edit', compact('dish', 'categories', 'restaurants'));
    }

    public function update(Request $request, Dish $dish)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:150',
            'description'   => 'nullable|string|max:500',
            'price'         => 'required|numeric|min:0',
            'image'         => 'nullable|image|max:2048',
            'available'     => 'boolean',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($dish->image) {
                    Storage::disk('public')->delete($dish->image);
                }
                $data['image'] = $request->file('image')->store('dishes', 'public');
            }

            $data['available'] = $request->boolean('available', true);
            $dish->update($data);

            if ($request->filled('back_to_restaurant')) {
                return redirect()->route('admin.restaurants.show', $request->back_to_restaurant)
                    ->with('success', 'Plato actualizado correctamente.');
            }

            return redirect()->route('admin.dishes.index')->with('success', 'Plato actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo actualizar el plato. Intente nuevamente.')->withInput();
        }
    }

    public function destroy(Dish $dish)
    {
        if ($dish->orderItems()->count() > 0) {
            return back()->with('error', 'No se puede eliminar un plato que tiene pedidos asociados.');
        }

        $restaurantId = $dish->restaurant_id;

        try {
            if ($dish->image) {
                Storage::disk('public')->delete($dish->image);
            }

            $dish->delete();

            // Si viene del formulario de gestión del restaurante, vuelve allí
            if (request()->filled('back_to_restaurant')) {
                return redirect()->route('admin.restaurants.show', request('back_to_restaurant'))
                    ->with('success', 'Plato eliminado correctamente.');
            }

            // Si la ruta anterior es la del restaurante, vuelve allí
            $referer = request()->headers->get('referer', '');
            if ($restaurantId && str_contains($referer, "/admin/restaurants/{$restaurantId}")) {
                return redirect()->route('admin.restaurants.show', $restaurantId)
                    ->with('success', 'Plato eliminado correctamente.');
            }

            return redirect()->route('admin.dishes.index')->with('success', 'Plato eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo eliminar el plato. Intente nuevamente.');
        }
    }
}
