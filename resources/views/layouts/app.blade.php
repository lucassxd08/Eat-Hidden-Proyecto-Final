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
<body class="bg-gray-950 text-white font-sans antialiased">

@auth
{{-- ===== LAYOUT CON SIDEBAR (usuarios autenticados) ===== --}}
<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-56 bg-gray-900 flex flex-col fixed h-full z-10 border-r border-gray-800">

        {{-- Logo --}}
        <div class="p-5 border-b border-gray-800">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center font-bold text-xs text-white">EH</div>
                <div>
                    <p class="font-bold text-white text-sm leading-tight">Eat Hidden</p>
                    <p class="text-xs text-gray-500 uppercase tracking-widest" style="font-size:9px">Dark Kitchen Perú</p>
                </div>
            </a>
        </div>

        {{-- Navegación --}}
        <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
            <p class="text-xs text-gray-600 uppercase tracking-widest px-3 py-2">Operaciones</p>

            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('home') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Inicio
            </a>

            <a href="{{ route('menu') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('menu') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Menú
            </a>

            @if(auth()->user()->isClient() || auth()->user()->isAdmin())
            <a href="{{ route('orders.restaurants') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('orders.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Pedido
            </a>
            @endif

            @if(auth()->user()->isClient())
            <a href="{{ route('orders.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Mis pedidos
            </a>
            @endif

            @if(auth()->user()->isKitchen() || auth()->user()->isAdmin())
            <a href="{{ route('kitchen.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('kitchen.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/></svg>
                Cocina
            </a>
            @endif

            @if(auth()->user()->isDelivery() || auth()->user()->isAdmin())
            <a href="{{ route('delivery.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('delivery.*') ? 'bg-gray-800 text-white' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Delivery
            </a>
            @endif

            @if(auth()->user()->isAdmin())
            <div class="pt-3">
                <p class="text-xs text-gray-600 uppercase tracking-widest px-3 py-2">Administración</p>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Pedidos
                </a>
                <a href="{{ route('admin.restaurants.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.restaurants.*') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Restaurantes
                </a>
                <a href="{{ route('admin.dishes.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.dishes.*') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Platos
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Categorías
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-400 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Usuarios
                </a>
            </div>
            @endif
        </nav>

        {{-- Usuario --}}
        <div class="p-4 border-t border-gray-800">
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
        <header class="bg-gray-900 border-b border-gray-800 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-400 rounded-full inline-block"></span>
                <span class="text-xs text-gray-400 uppercase tracking-widest">Cocina activa</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs bg-gray-800 border border-gray-700 text-gray-300 px-3 py-1 rounded uppercase tracking-widest font-semibold">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                <span class="text-xs text-gray-500">{{ now()->format('l, d M') }}</span>
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
<nav class="bg-gray-900 text-white shadow-lg border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center font-bold text-xs">EH</div>
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

<footer class="bg-gray-900 text-gray-400 mt-16 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 bg-red-500 rounded-lg flex items-center justify-center font-bold text-xs">EH</div>
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
    <div class="border-t border-gray-800 text-center py-4 text-xs">
        &copy; {{ date('Y') }} Eat Hidden Perú. Todos los derechos reservados.
    </div>
</footer>
@endauth

</body>
</html>
