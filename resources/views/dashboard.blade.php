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
        <div class="bg-gray-800 border border-red-500 rounded-xl p-5 flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Ingresos del día</p>
                <p class="text-2xl font-bold text-white">S/ {{ number_format($stats['ingresos_hoy'], 2) }}</p>
            </div>
            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Pendientes</p>
                <p class="text-2xl font-bold text-white">{{ $stats['pendientes'] }}</p>
            </div>
            <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Preparando</p>
                <p class="text-2xl font-bold text-white">{{ $stats['preparando'] }}</p>
            </div>
            <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Listos</p>
                <p class="text-2xl font-bold text-white">{{ $stats['listos'] }}</p>
            </div>
            <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="mb-8">
        <h2 class="text-white font-semibold mb-4">Accesos rápidos</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('menu') }}" class="bg-gray-800 border border-gray-700 hover:border-red-500 rounded-xl p-5 transition group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-white font-semibold text-sm">Abrir menú</p>
                <p class="text-gray-500 text-xs mt-1">Explora y arma pedidos</p>
            </a>
            <a href="{{ route('orders.restaurants') }}" class="bg-gray-800 border border-gray-700 hover:border-red-500 rounded-xl p-5 transition group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <p class="text-white font-semibold text-sm">Pedido activo</p>
                <p class="text-gray-500 text-xs mt-1">Revisa el carrito</p>
            </a>
            <a href="{{ route('kitchen.index') }}" class="bg-gray-800 border border-gray-700 hover:border-red-500 rounded-xl p-5 transition group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2z"/></svg>
                <p class="text-white font-semibold text-sm">Cocina</p>
                <p class="text-gray-500 text-xs mt-1">Tablero de preparación</p>
            </a>
            <a href="{{ route('delivery.index') }}" class="bg-gray-800 border border-gray-700 hover:border-red-500 rounded-xl p-5 transition group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 mb-3 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <p class="text-white font-semibold text-sm">Delivery</p>
                <p class="text-gray-500 text-xs mt-1">Despacha pedidos listos</p>
            </a>
        </div>
    </div>

    {{-- Pedidos recientes --}}
    <div>
        <h2 class="text-white font-semibold mb-4">Pedidos recientes</h2>
        <div class="bg-gray-800 rounded-xl border border-gray-700 divide-y divide-gray-700">
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
