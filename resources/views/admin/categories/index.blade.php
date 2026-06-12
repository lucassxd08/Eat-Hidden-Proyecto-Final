@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Categorías</h1>
            <p class="text-gray-500 mt-1">Mantenimiento de categorías del menú</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-lg transition">
            + Nueva categoría
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">Nombre</th>
                    <th class="px-6 py-4 text-left">Descripción</th>
                    <th class="px-6 py-4 text-center">Platos</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $category->description ?? '—' }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $category->dishes_count }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($category->active)
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Activa</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">Inactiva</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline text-xs font-medium">Editar</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline text-xs font-medium">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">No hay categorías registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
