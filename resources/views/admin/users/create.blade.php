@extends('layouts.app')
@section('title', 'Nuevo Usuario')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-red-500 hover:underline text-sm">&larr; Volver a usuarios</a>
        <h1 class="text-3xl font-bold text-white mt-2">Nuevo usuario</h1>
    </div>

    <div class="bg-zinc-900 rounded-2xl shadow p-8">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Nombre *</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Contraseña *</label>
                    <input type="password" name="password"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('password') border-red-400 @enderror">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Confirmar contraseña *</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Perfil *</label>
                    <select name="role"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('role') border-red-400 @enderror">
                        <option value="">— Seleccionar —</option>
                        <option value="admin"    {{ old('role') === 'admin'    ? 'selected' : '' }}>Administrador</option>
                        <option value="kitchen"  {{ old('role') === 'kitchen'  ? 'selected' : '' }}>Personal de cocina</option>
                        <option value="delivery" {{ old('role') === 'delivery' ? 'selected' : '' }}>Repartidor</option>
                        <option value="client"   {{ old('role') === 'client'   ? 'selected' : '' }}>Cliente</option>
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1">Dirección</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                        class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="border border-zinc-700 text-gray-400 px-5 py-2 rounded-lg hover:bg-zinc-800 text-sm transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2 rounded-lg text-sm transition">
                    Crear usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

