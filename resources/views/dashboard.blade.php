@extends('layouts.app')
@section('title', 'Inicio')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    {{-- Saludo --}}
    <div class="mb-8">
        <p class="text-red-500 text-xs font-bold uppercase tracking-widest mb-1">Bienvenido</p>
        <h1 class="text-3xl font-bold text-white">
            Hola {{ auth()->user()->name }}, tu cocina está <span class="text-red-500">en línea</span>.
        </h1>
        <p class="text-gray-400 mt-1">Esto es lo que está pasando ahora.</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-zinc-900 border border-red-500 rounded-xl p-5 flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Ingresos del día</p>
                <p class="text-2xl font-bold text-white">S/ {{ number_format($stats['ingresos_hoy'], 2) }}</p>
            </div>
            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-5 flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Pendientes</p>
                <p class="text-2xl font-bold text-white">{{ $stats['pendientes'] }}</p>
            </div>
            <div class="w-10 h-10 bg-zinc-800 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-5 flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Preparando</p>
                <p class="text-2xl font-bold text-white">{{ $stats['preparando'] }}</p>
            </div>
            <div class="w-10 h-10 bg-zinc-800 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-5 flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Listos</p>
                <p class="text-2xl font-bold text-white">{{ $stats['listos'] }}</p>
            </div>
            <div class="w-10 h-10 bg-zinc-800 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos: CRUDs solo para admin --}}
    @if(auth()->user()->isAdmin())
    <div class="mb-8">
        <h2 class="text-white font-semibold mb-4">Gestión</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.restaurants.index') }}" class="bg-zinc-900 border border-zinc-700 hover:border-red-500 rounded-xl p-5 transition group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <p class="text-white font-semibold text-sm">Restaurantes</p>
                <p class="text-gray-500 text-xs mt-1">Dark kitchens</p>
            </a>
            <a href="{{ route('admin.dishes.index') }}" class="bg-zinc-900 border border-zinc-700 hover:border-red-500 rounded-xl p-5 transition group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <p class="text-white font-semibold text-sm">Platos</p>
                <p class="text-gray-500 text-xs mt-1">Menú de platos</p>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="bg-zinc-900 border border-zinc-700 hover:border-red-500 rounded-xl p-5 transition group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <p class="text-white font-semibold text-sm">Categorías</p>
                <p class="text-gray-500 text-xs mt-1">Tipos de platos</p>
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-zinc-900 border border-zinc-700 hover:border-red-500 rounded-xl p-5 transition group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <p class="text-white font-semibold text-sm">Usuarios</p>
                <p class="text-gray-500 text-xs mt-1">Gestión de perfiles</p>
            </a>
        </div>
    </div>
    @endif

    {{-- Pedidos recientes --}}
    <div>
        <h2 class="text-white font-semibold mb-4">Pedidos recientes</h2>
        <div class="bg-zinc-900 rounded-xl border border-zinc-700 divide-y divide-zinc-800">
            @forelse($pedidos_recientes as $pedido)
            <div class="flex items-center justify-between px-5 py-4">
                <div class="flex items-center gap-4">
                    <span class="text-red-500 font-bold text-sm">#{{ $pedido->id }}</span>
                    <span class="text-gray-300 text-sm">
                        {{ $pedido->items->map(fn($i) => $i->quantity.'× '.$i->dish->name)->join(', ') }}
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-gray-500 text-xs uppercase tracking-wider">{{ strtoupper($pedido->status) }}</span>
                    <span class="text-white font-semibold text-sm">S/ {{ number_format($pedido->total, 2) }}</span>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-gray-500 text-sm">No hay pedidos aún.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
