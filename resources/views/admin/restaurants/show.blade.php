@extends('layouts.app')
@section('title', 'Gestionar — ' . $restaurant->name)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8 space-y-8">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.restaurants.index') }}" class="text-red-500 hover:underline text-sm">← Volver a restaurantes</a>
            <h1 class="text-2xl font-bold text-white mt-1">{{ $restaurant->name }}</h1>
            @if($restaurant->description)
                <p class="text-gray-500 text-sm mt-1">{{ $restaurant->description }}</p>
            @endif
        </div>
        <div class="flex items-center gap-3">
            <span class="{{ $restaurant->active ? 'bg-green-900 text-green-300' : 'bg-zinc-800 text-gray-400' }} text-xs px-3 py-1 rounded-full font-semibold">
                {{ $restaurant->active ? 'Activo' : 'Inactivo' }}
            </span>
            <a href="{{ route('admin.restaurants.edit', $restaurant) }}"
               class="border border-zinc-700 text-gray-300 hover:bg-zinc-800 px-4 py-2 rounded-lg text-sm transition">
                Editar restaurante
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    {{-- Formulario: añadir plato --}}
    <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-6">
        <h2 class="text-lg font-bold text-white mb-4">Añadir nuevo plato</h2>
        <form method="POST" action="{{ route('admin.dishes.store') }}">
            @csrf
            <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
            <input type="hidden" name="back_to_restaurant" value="{{ $restaurant->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Categoría *</label>
                    <select name="category_id"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('category_id') border-red-400 @enderror">
                        <option value="">— Seleccionar existente —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <input type="text" name="new_category" value="{{ old('new_category') }}"
                        placeholder="O escribe una nueva (ej. Combos, Postres...)"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('new_category') border-red-400 @enderror">
                    @error('new_category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-500">Elige del selector o escribe una nueva. Se crea automáticamente.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Nombre del plato *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej. Burger Clásica"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1">Descripción</label>
                    <input type="text" name="description" value="{{ old('description') }}" placeholder="Ingredientes o descripción breve"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Precio (S/) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" placeholder="0.00"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('price') border-red-400 @enderror">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-end gap-3 pb-1">
                    <label class="flex items-center gap-2 text-sm text-gray-300 cursor-pointer">
                        <input type="hidden" name="available" value="0">
                        <input type="checkbox" name="available" value="1" checked class="w-4 h-4 accent-red-500">
                        Disponible en el menú
                    </label>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-lg text-sm transition">
                    + Añadir plato
                </button>
            </div>
        </form>
    </div>

    {{-- Tabla de platos actuales --}}
    <div class="bg-zinc-900 rounded-2xl border border-zinc-800 overflow-hidden">
        <div class="px-6 py-4 flex items-center justify-between border-b border-zinc-800">
            <h2 class="text-lg font-bold text-white">Platos del restaurante <span class="text-gray-400 font-normal text-sm">({{ $restaurant->dishes->count() }})</span></h2>
        </div>

        @if($restaurant->dishes->isEmpty())
            <div class="px-6 py-10 text-center text-gray-500">Este restaurante aún no tiene platos.</div>
        @else
        <table class="w-full text-sm">
            <thead class="bg-zinc-950 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Categoría</th>
                    <th class="px-6 py-3 text-left">Descripción</th>
                    <th class="px-6 py-3 text-right">Precio</th>
                    <th class="px-6 py-3 text-center">Estado</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @foreach($restaurant->dishes as $dish)
                <tr class="hover:bg-zinc-800">
                    <td class="px-6 py-4 font-medium text-white">{{ $dish->name }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $dish->category->name ?? '—' }}</td>
                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $dish->description ?? '—' }}</td>
                    <td class="px-6 py-4 text-right font-semibold text-red-500">S/ {{ number_format($dish->price, 2) }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($dish->available)
                            <span class="bg-green-900 text-green-300 text-xs px-2 py-1 rounded-full">Disponible</span>
                        @else
                            <span class="bg-zinc-800 text-gray-400 text-xs px-2 py-1 rounded-full">No disponible</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('admin.dishes.edit', $dish) }}?back={{ $restaurant->id }}"
                           class="text-blue-400 hover:underline text-xs">Editar</a>
                        <form action="{{ route('admin.dishes.destroy', $dish) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Eliminar este plato?')">
                            @csrf @method('DELETE')
                            <input type="hidden" name="back_to_restaurant" value="{{ $restaurant->id }}">
                            <button class="text-red-500 hover:underline text-xs">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
@endsection
