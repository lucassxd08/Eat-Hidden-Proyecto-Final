@extends('layouts.app')
@section('title', 'Restaurantes')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Restaurantes</h1>
        <a href="{{ route('admin.restaurants.create') }}"
           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold">
            + Nuevo Restaurante
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('error') }}</div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-900 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Descripción</th>
                    <th class="px-6 py-3 text-center">Platos</th>
                    <th class="px-6 py-3 text-center">Estado</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($restaurants as $restaurant)
                <tr class="hover:bg-gray-700">
                    <td class="px-6 py-4 font-semibold text-white">{{ $restaurant->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ Str::limit($restaurant->description, 50) }}</td>
                    <td class="px-6 py-4 text-center">{{ $restaurant->dishes_count }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($restaurant->active)
                            <span class="bg-green-900 text-green-300 text-xs px-2 py-1 rounded-full">Activo</span>
                        @else
                            <span class="bg-red-900 text-red-300 text-xs px-2 py-1 rounded-full">Inactivo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('admin.restaurants.edit', $restaurant) }}"
                           class="text-blue-400 hover:underline">Editar</a>
                        <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Eliminar este restaurante?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">No hay restaurantes registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
