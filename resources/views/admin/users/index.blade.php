@extends('layouts.app')
@section('title', 'Gestión de Usuarios')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Usuarios</h1>
            <p class="text-gray-500 mt-1">Gestión de usuarios y perfiles del sistema</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-lg transition">
            + Nuevo usuario
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">Nombre</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">Perfil</th>
                    <th class="px-6 py-4 text-left">Teléfono</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @php
                            $roleColors = [
                                'admin'    => 'bg-red-100 text-red-700',
                                'kitchen'  => 'bg-yellow-100 text-yellow-700',
                                'delivery' => 'bg-blue-100 text-blue-700',
                                'client'   => 'bg-green-100 text-green-700',
                            ];
                            $roleLabels = [
                                'admin'    => 'Administrador',
                                'kitchen'  => 'Cocina',
                                'delivery' => 'Repartidor',
                                'client'   => 'Cliente',
                            ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $roleLabels[$user->role] ?? $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->phone ?? '—' }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline text-xs font-medium">Editar</a>
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('¿Eliminar este usuario?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline text-xs font-medium">Eliminar</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">No hay usuarios registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
