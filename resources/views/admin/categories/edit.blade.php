@extends('layouts.app')
@section('title', 'Editar Categoría')

@section('content')
<div class="max-w-xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-orange-500 hover:underline text-sm">&larr; Volver a categorías</a>
        <h1 class="text-3xl font-bold text-gray-900 mt-2">Editar categoría</h1>
    </div>

    <div class="bg-white rounded-2xl shadow p-8">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf @method('PATCH')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <input type="text" name="description" value="{{ old('description', $category->description) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" name="active" value="1" id="active"
                        {{ old('active', $category->active) ? 'checked' : '' }}
                        class="w-4 h-4 accent-orange-500">
                    <label for="active" class="text-sm font-medium text-gray-700">Categoría activa</label>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="border border-gray-300 text-gray-600 px-5 py-2 rounded-lg hover:bg-gray-50 text-sm transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2 rounded-lg text-sm transition">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
