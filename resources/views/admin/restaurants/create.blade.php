@extends('layouts.app')
@section('title', 'Nuevo Restaurante')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-white mb-6">Nuevo Restaurante</h1>

    <form action="{{ route('admin.restaurants.store') }}" method="POST" class="bg-gray-800 rounded-xl shadow p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Nombre *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-red-400">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Descripción</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-red-400">{{ old('description') }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="active" value="1" id="active" checked
                   class="w-4 h-4 accent-red-500">
            <label for="active" class="text-sm text-gray-300">Restaurante activo (visible para clientes)</label>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold">
                Guardar
            </button>
            <a href="{{ route('admin.restaurants.index') }}"
               class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-6 py-2 rounded-lg font-semibold">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
