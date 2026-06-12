<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('dishes')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string|max:255',
            'active'      => 'boolean',
        ]);

        $data['active'] = $request->boolean('active', true);
        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:255',
            'active'      => 'boolean',
        ]);

        $data['active'] = $request->boolean('active', true);
        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $category)
    {
        if ($category->dishes()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una categoría que tiene platos asignados.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Categoría eliminada.');
    }
}
