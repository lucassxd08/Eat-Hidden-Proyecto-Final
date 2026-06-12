<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EatHidden') }} - @yield('title', 'Dark Kitchen Delivery')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

{{-- Navbar --}}
<nav class="bg-gray-900 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="font-bold text-xl text-orange-400">
                EatHidden
            </a>

            <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-orange-400 transition">Inicio</a>
                <a href="{{ route('menu') }}" class="hover:text-orange-400 transition">Menú</a>
                <a href="{{ route('about') }}" class="hover:text-orange-400 transition">Nosotros</a>

                @auth
                    @if(auth()->user()->isClient())
                        <a href="{{ route('orders.menu') }}" class="hover:text-orange-400 transition">Pedir ahora</a>
                        <a href="{{ route('orders.index') }}" class="hover:text-orange-400 transition">Mis pedidos</a>
                    @endif
                    @if(auth()->user()->isKitchen())
                        <a href="{{ route('kitchen.index') }}" class="hover:text-orange-400 transition">Cocina</a>
                    @endif
                    @if(auth()->user()->isDelivery())
                        <a href="{{ route('delivery.index') }}" class="hover:text-orange-400 transition">Mis entregas</a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="hover:text-orange-400 transition">Usuarios</a>
                        <a href="{{ route('admin.categories.index') }}" class="hover:text-orange-400 transition">Categorías</a>
                        <a href="{{ route('admin.dishes.index') }}" class="hover:text-orange-400 transition">Platos</a>
                        <a href="{{ route('kitchen.index') }}" class="hover:text-orange-400 transition">Cocina</a>
                        <a href="{{ route('delivery.index') }}" class="hover:text-orange-400 transition">Entregas</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-3 text-sm">
                @auth
                    <span class="text-gray-400 hidden sm:inline">{{ auth()->user()->name }}</span>
                    <span class="text-xs bg-orange-500 text-white px-2 py-0.5 rounded-full">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="hover:text-orange-400 transition">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-orange-400 transition">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1.5 rounded-lg transition">Registrarse</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
    <div class="max-w-7xl mx-auto mt-4 px-4">
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    </div>
@endif
@if(session('error'))
    <div class="max-w-7xl mx-auto mt-4 px-4">
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    </div>
@endif

<main>
    @yield('content')
</main>

<footer class="bg-gray-900 text-gray-400 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <p class="text-orange-400 font-bold text-lg mb-2">EatHidden</p>
            <p class="text-sm">Dark kitchen delivery. Comida de calidad, directo a tu puerta.</p>
        </div>
        <div>
            <p class="font-semibold text-white mb-2">Enlacies</p>
            <ul class="space-y-1 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-orange-400">Inicio</a></li>
                <li><a href="{{ route('menu') }}" class="hover:text-orange-400">Menú</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-orange-400">Nosotros</a></li>
            </ul>
        </div>
        <div>
            <p class="font-semibold text-white mb-2">Horario</p>
            <p class="text-sm">Lunes a Domingo</p>
            <p class="text-sm">12:00 pm – 10:00 pm</p>
        </div>
    </div>
    <div class="border-t border-gray-700 text-center py-4 text-xs">
        &copy; {{ date('Y') }} EatHidden. Todos los derechos reservados.
    </div>
</footer>

</body>
</html>
