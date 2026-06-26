<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EatHidden') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-950">
<div class="min-h-screen flex">

    <div class="hidden lg:flex lg:w-1/2 bg-gray-950 flex-col justify-between p-12 relative overflow-hidden border-r border-gray-800">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.04) 1px, transparent 0); background-size: 32px 32px;"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-red-500 rounded-full opacity-10 blur-3xl"></div>

        <div class="relative z-10 flex items-center gap-3">
            <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center text-xl">🍔</div>
            <div>
                <p class="font-bold text-white text-base leading-tight">Eat Hidden</p>
                <p class="text-gray-500 uppercase tracking-widest" style="font-size:9px">Dark Kitchen Perú</p>
            </div>
        </div>

        <div class="relative z-10">
            <p class="text-red-500 text-xs font-bold uppercase tracking-widest mb-4">Plataforma de gestión</p>
            <h1 class="text-5xl font-extrabold text-white leading-tight mb-5">
                Cocina <span class="text-red-500">oculta</span>,<br>sabor visible.
            </h1>
            <p class="text-gray-500 text-lg leading-relaxed">
                Gestión integral para dark kitchens.<br>Pedidos, menú y entregas en un solo lugar.
            </p>
        </div>

        <div class="relative z-10 flex gap-10">
            <div>
                <p class="text-2xl font-bold text-white">+120</p>
                <p class="text-gray-600 text-sm mt-0.5">Platos disponibles</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">4</p>
                <p class="text-gray-600 text-sm mt-0.5">Cocinas activas</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">24/7</p>
                <p class="text-gray-600 text-sm mt-0.5">Soporte online</p>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 bg-gray-900 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <div class="lg:hidden flex items-center gap-3 mb-8">
                <div class="w-9 h-9 bg-red-500 rounded-xl flex items-center justify-center text-lg">🍔</div>
                <p class="font-bold text-white text-base">Eat Hidden</p>
            </div>
            {{ $slot }}
        </div>
    </div>

</div>
</body>
</html>
