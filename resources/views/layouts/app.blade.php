<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EatHidden') }} - @yield('title', 'Dark Kitchen')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white font-sans antialiased">

@auth
{{-- ===== LAYOUT CON SIDEBAR (usuarios autenticados) ===== --}}
<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-56 bg-zinc-950 flex flex-col fixed h-full z-10 border-r border-zinc-800">

        {{-- Logo --}}
        <div class="p-5 border-b border-zinc-800">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center text-base">🍔</div>
                <div>
                    <p class="font-bold text-white text-sm leading-tight">Eat Hidden</p>
                    <p class="text-xs text-gray-500 uppercase tracking-widest" style="font-size:9px">Dark Kitchen Perú</p>
                </div>
            </a>
        </div>

        {{-- Navegación --}}
        <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">

            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-zinc-900 hover:text-white transition {{ request()->routeIs('home') ? 'bg-zinc-900 text-white' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Inicio
            </a>

            <a href="{{ route('menu') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-zinc-900 hover:text-white transition {{ request()->routeIs('menu') ? 'bg-zinc-900 text-white' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Menú
            </a>

            @php $cocina_count = \App\Models\Order::whereIn('status', ['pending','confirmed','preparing'])->count(); @endphp
            <a href="{{ auth()->user()->isAdmin() ? route('kitchen.index') : route('kitchen.index') }}"
               class="flex items-center justify-between px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-zinc-900 hover:text-white transition {{ request()->routeIs('kitchen.*') ? 'bg-zinc-900 text-white' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/></svg>
                    Cocina
                </span>
                @if($cocina_count > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $cocina_count }}</span>
                @endif
            </a>

            @php $delivery_count = \App\Models\Order::where('status', 'ready')->count(); @endphp
            @php
                $pedidosRoute = auth()->user()->isAdmin()
                    ? route('admin.orders.index')
                    : (auth()->user()->isClient() ? route('orders.index') : route('orders.restaurants'));
                $pedidosActive = request()->routeIs('admin.orders.*') || request()->routeIs('orders.*');
            @endphp
            <a href="{{ $pedidosRoute }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-zinc-900 hover:text-white transition {{ $pedidosActive ? 'bg-zinc-900 text-white' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Pedidos
            </a>

            <a href="{{ route('delivery.index') }}"
               class="flex items-center justify-between px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-zinc-900 hover:text-white transition {{ request()->routeIs('delivery.*') ? 'bg-zinc-900 text-white' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Delivery
                </span>
                @if($delivery_count > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $delivery_count }}</span>
                @endif
            </a>

        </nav>

        {{-- Usuario --}}
        <div class="p-4 border-t border-zinc-800">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2 min-w-0">
                    <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-xs font-bold shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-white truncate">{{ auth()->user()->email }}</p>
                        <p class="text-xs text-green-400">En línea</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-gray-500 hover:text-white transition" title="Cerrar sesión">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Contenido principal --}}
    <div class="ml-56 flex-1 flex flex-col min-h-screen">

        {{-- Barra superior --}}
        <header class="bg-zinc-950 border-b border-zinc-800 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-400 rounded-full inline-block"></span>
                <span class="text-xs text-gray-400 uppercase tracking-widest">Cocina activa</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs bg-zinc-900 border border-zinc-700 text-gray-300 px-3 py-1 rounded uppercase tracking-widest font-semibold">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mx-6 mt-4 bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mx-6 mt-4 bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <main class="flex-1">
            @yield('content')
        </main>
    </div>
</div>

@else
{{-- ===== LAYOUT PÚBLICO (sin sesión) ===== --}}
<nav class="bg-zinc-950 text-white shadow-lg border-b border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center text-base">🍔</div>
                <div>
                    <p class="font-bold text-white text-sm leading-tight">Eat Hidden</p>
                    <p class="text-gray-500 uppercase tracking-widest" style="font-size:9px">Dark Kitchen Perú</p>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-300">
                <a href="{{ route('home') }}" class="hover:text-red-400 transition">Inicio</a>
                <a href="{{ route('menu') }}" class="hover:text-red-400 transition">Menú</a>
                <a href="{{ route('about') }}" class="hover:text-red-400 transition">Nosotros</a>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-red-400 transition">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg transition">Registrarse</a>
            </div>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="max-w-7xl mx-auto mt-4 px-4">
        <div class="bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    </div>
@endif
@if(session('error'))
    <div class="max-w-7xl mx-auto mt-4 px-4">
        <div class="bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    </div>
@endif

<main>
    @yield('content')
</main>

<footer class="bg-zinc-950 text-gray-400 mt-16 border-t border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 bg-red-500 rounded-lg flex items-center justify-center text-sm">🍔</div>
                <p class="text-white font-bold">Eat Hidden</p>
            </div>
            <p class="text-sm">Dark kitchen delivery. Comida de calidad, directo a tu puerta.</p>
        </div>
        <div>
            <p class="font-semibold text-white mb-2">Enlaces</p>
            <ul class="space-y-1 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-red-400">Inicio</a></li>
                <li><a href="{{ route('menu') }}" class="hover:text-red-400">Menú</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-red-400">Nosotros</a></li>
            </ul>
        </div>
        <div>
            <p class="font-semibold text-white mb-2">Horario</p>
            <p class="text-sm">Lunes a Domingo</p>
            <p class="text-sm">12:00 pm – 10:00 pm</p>
        </div>
    </div>
    <div class="border-t border-zinc-800 text-center py-4 text-xs">
        &copy; {{ date('Y') }} Eat Hidden Perú. Todos los derechos reservados.
    </div>
</footer>
@endauth

</body>
</html>
