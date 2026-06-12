<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::with('category')->orderBy('name')->get();
        return view('admin.dishes.index', compact('dishes'));
    }

    public function create()
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        return view('admin.dishes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'available'   => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('dishes', 'public');
        }

        $data['available'] = $request->boolean('available', true);
        Dish::create($data);

        return redirect()->route('admin.dishes.index')->with('success', 'Plato creado correctamente.');
    }

    public function edit(Dish $dish)
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        return view('admin.dishes.edit', compact('dish', 'categories'));
    }

    public function update(Request $request, Dish $dish)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'available'   => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($dish->image) {
                Storage::disk('public')->delete($dish->image);
            }
            $data['image'] = $request->file('image')->store('dishes', 'public');
        }

        $data['available'] = $request->boolean('available', true);
        $dish->update($data);

        return redirect()->route('admin.dishes.index')->with('success', 'Plato actualizado correctamente.');
    }

    public function destroy(Dish $dish)
    {
        if ($dish->orderItems()->count() > 0) {
            return back()->with('error', 'No se puede eliminar un plato que tiene pedidos asociados.');
        }

        if ($dish->image) {
            Storage::disk('public')->delete($dish->image);
        }

        $dish->delete();
        return redirect()->route('admin.dishes.index')->with('success', 'Plato eliminado.');
    }
}
