@extends('layouts.app')
@section('title', 'Platos')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Platos</h1>
            <p class="text-gray-500 mt-1">Mantenimiento del menú de platos</p>
        </div>
        <a href="{{ route('admin.dishes.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-lg transition">
            + Nuevo plato
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">Nombre</th>
                    <th class="px-6 py-4 text-left">Categoría</th>
                    <th class="px-6 py-4 text-left">Descripción</th>
                    <th class="px-6 py-4 text-right">Precio</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($dishes as $dish)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $dish->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $dish->category->name }}</td>
                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $dish->description ?? '—' }}</td>
                    <td class="px-6 py-4 text-right font-semibold text-orange-600">S/ {{ number_format($dish->price, 2) }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($dish->available)
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Disponible</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">No disponible</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.dishes.edit', $dish) }}" class="text-blue-600 hover:underline text-xs font-medium">Editar</a>
                            <form method="POST" action="{{ route('admin.dishes.destroy', $dish) }}" onsubmit="return confirm('¿Eliminar este plato?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline text-xs font-medium">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">No hay platos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
