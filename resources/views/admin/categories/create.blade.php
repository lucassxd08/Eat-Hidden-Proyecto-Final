@extends('layouts.app')
@section('title', 'Nueva Categoría')

@section('content')
<div class="max-w-xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-red-500 hover:underline text-sm">&larr; Volver a categorías</a>
        <h1 class="text-3xl font-bold text-white mt-2">Nueva categoría</h1>
    </div>

    <div class="bg-zinc-900 rounded-2xl shadow p-8">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Nombre *</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Descripción</label>
                    <input type="text" name="description" value="{{ old('description') }}"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" name="active" value="1" id="active" {{ old('active', '1') ? 'checked' : '' }}
                        class="w-4 h-4 accent-red-500">
                    <label for="active" class="text-sm font-medium text-gray-300">Categoría activa</label>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="border border-zinc-700 text-gray-400 px-5 py-2 rounded-lg hover:bg-zinc-800 text-sm transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2 rounded-lg text-sm transition">
                    Crear categoría
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

