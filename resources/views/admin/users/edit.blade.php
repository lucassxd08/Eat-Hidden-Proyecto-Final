@extends('layouts.app')
@section('title', 'Editar Usuario')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-red-500 hover:underline text-sm">&larr; Volver a usuarios</a>
        <h1 class="text-3xl font-bold text-white mt-2">Editar usuario</h1>
    </div>

    <div class="bg-gray-800 rounded-2xl shadow p-8">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PATCH')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Nombre *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Nueva contraseña <span class="text-gray-400">(opcional)</span></label>
                    <input type="password" name="password"
                        class="w-full border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Perfil *</label>
                    <select name="role"
                        class="w-full border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                        <option value="admin"    {{ old('role', $user->role) === 'admin'    ? 'selected' : '' }}>Administrador</option>
                        <option value="kitchen"  {{ old('role', $user->role) === 'kitchen'  ? 'selected' : '' }}>Personal de cocina</option>
                        <option value="delivery" {{ old('role', $user->role) === 'delivery' ? 'selected' : '' }}>Repartidor</option>
                        <option value="client"   {{ old('role', $user->role) === 'client'   ? 'selected' : '' }}>Cliente</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1">Dirección</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                        class="w-full border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="border border-gray-600 text-gray-400 px-5 py-2 rounded-lg hover:bg-gray-700 text-sm transition">
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

