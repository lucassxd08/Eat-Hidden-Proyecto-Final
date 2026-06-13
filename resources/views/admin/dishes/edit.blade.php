@extends('layouts.app')
@section('title', 'Editar Plato')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.dishes.index') }}" class="text-red-500 hover:underline text-sm">&larr; Volver a platos</a>
        <h1 class="text-3xl font-bold text-gray-900 mt-2">Editar plato</h1>
    </div>

    <div class="bg-white rounded-2xl shadow p-8">
        <form method="POST" action="{{ route('admin.dishes.update', $dish) }}" enctype="multipart/form-data">
            @csrf @method('PATCH')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Restaurante *</label>
                    <select name="restaurant_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="">— Seleccionar restaurante —</option>
                        @foreach($restaurants as $restaurant)
                            <option value="{{ $restaurant->id }}" {{ old('restaurant_id', $dish->restaurant_id) == $restaurant->id ? 'selected' : '' }}>
                                {{ $restaurant->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('restaurant_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                    <select name="category_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $dish->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                    <input type="text" name="name" value="{{ old('name', $dish->name) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">{{ old('description', $dish->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio (S/) *</label>
                    <input type="number" name="price" value="{{ old('price', $dish->price) }}" step="0.01" min="0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagen <span class="text-gray-400">(dejar vacío para mantener la actual)</span></label>
                    @if($dish->image)
                        <p class="text-xs text-gray-400 mb-1">Imagen actual: {{ basename($dish->image) }}</p>
                    @endif
                    <input type="file" name="image" accept="image/*"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="available" value="0">
                    <input type="checkbox" name="available" value="1" id="available"
                        {{ old('available', $dish->available) ? 'checked' : '' }}
                        class="w-4 h-4 accent-red-500">
                    <label for="available" class="text-sm font-medium text-gray-700">Disponible en el menú</label>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.dishes.index') }}" class="border border-gray-300 text-gray-600 px-5 py-2 rounded-lg hover:bg-gray-50 text-sm transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2 rounded-lg text-sm transition">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

