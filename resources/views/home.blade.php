@extends('layouts.app')
@section('title', 'Inicio')

@section('content')

{{-- Hero --}}
<section class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-24 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1">
            <span class="text-orange-400 font-semibold text-sm uppercase tracking-wider">Plataforma de delivery</span>
            <h1 class="text-4xl md:text-6xl font-bold mt-3 leading-tight">
                Las mejores<br>
                <span class="text-orange-400">dark kitchens,</span><br>
                en un solo lugar.
            </h1>
            <p class="mt-6 text-gray-300 text-lg max-w-xl">
                EatHidden reúne varias cocinas ocultas especializadas. Chefs profesionales,
                sin local, sin esperas innecesarias. Solo sabor directo a tu puerta.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('orders.menu') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-8 py-3 rounded-xl transition">
                    Pedir ahora
                </a>
                <a href="{{ route('menu') }}" class="border border-white hover:border-orange-400 hover:text-orange-400 text-white font-semibold px-8 py-3 rounded-xl transition">
                    Ver menú completo
                </a>
            </div>
        </div>
        <div class="flex-1 flex justify-center">
            <div class="bg-gray-800 rounded-2xl p-10 text-center shadow-2xl w-72">
                <div class="text-7xl mb-4">🍽</div>
                <p class="text-orange-400 font-semibold text-lg">Múltiples cocinas</p>
                <p class="text-gray-400 text-sm mt-1">Un solo pedido, un solo delivery</p>
                <div class="mt-4 flex justify-center gap-4 text-3xl">🍔 🌮 🍜 🍕</div>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="bg-orange-500 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div>
            <p class="text-4xl font-bold">{{ $categories->count() }}+</p>
            <p class="text-orange-100 mt-1">Categorías</p>
        </div>
        <div>
            <p class="text-4xl font-bold">{{ $featuredDishes->count() }}+</p>
            <p class="text-orange-100 mt-1">Platos disponibles</p>
        </div>
        <div>
            <p class="text-4xl font-bold">30</p>
            <p class="text-orange-100 mt-1">Min. de entrega</p>
        </div>
        <div>
            <p class="text-4xl font-bold">7</p>
            <p class="text-orange-100 mt-1">Días a la semana</p>
        </div>
    </div>
</section>

{{-- Cómo funciona --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">¿Cómo funciona?</h2>
        <p class="text-center text-gray-500 mb-12">De la cocina a tu puerta en simples pasos</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-6 bg-gray-50 rounded-2xl">
                <div class="text-5xl mb-4">📋</div>
                <h3 class="text-lg font-semibold mb-2">1. Elegís tu cocina</h3>
                <p class="text-gray-500 text-sm">Explorá las distintas dark kitchens y sus especialidades.</p>
            </div>
            <div class="text-center p-6 bg-gray-50 rounded-2xl">
                <div class="text-5xl mb-4">🛒</div>
                <h3 class="text-lg font-semibold mb-2">2. Armás tu pedido</h3>
                <p class="text-gray-500 text-sm">Seleccioná los platos que querés y confirmás el pedido.</p>
            </div>
            <div class="text-center p-6 bg-gray-50 rounded-2xl">
                <div class="text-5xl mb-4">👨‍🍳</div>
                <h3 class="text-lg font-semibold mb-2">3. La cocina prepara</h3>
                <p class="text-gray-500 text-sm">El equipo de cocina recibe y prepara tu orden.</p>
            </div>
            <div class="text-center p-6 bg-gray-50 rounded-2xl">
                <div class="text-5xl mb-4">🛵</div>
                <h3 class="text-lg font-semibold mb-2">4. Lo recibís</h3>
                <p class="text-gray-500 text-sm">El repartidor lleva tu pedido directo a tu domicilio.</p>
            </div>
        </div>
    </div>
</section>

{{-- Platos destacados --}}
@if($featuredDishes->count())
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">Platos destacados</h2>
        <p class="text-center text-gray-500 mb-12">Lo más pedido de nuestras cocinas esta semana</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredDishes as $dish)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition group">
                <div class="bg-orange-50 h-40 flex items-center justify-center text-6xl group-hover:bg-orange-100 transition">
                    🍽
                </div>
                <div class="p-5">
                    <span class="text-xs text-orange-500 font-semibold uppercase">{{ $dish->category->name }}</span>
                    <h3 class="font-bold text-lg mt-1">{{ $dish->name }}</h3>
                    @if($dish->description)
                        <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $dish->description }}</p>
                    @endif
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-orange-500 font-bold text-xl">S/ {{ number_format($dish->price, 2) }}</span>
                        <a href="{{ route('orders.menu') }}" class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-2 rounded-lg transition">
                            Pedir
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('menu') }}" class="bg-gray-900 hover:bg-gray-700 text-white font-semibold px-8 py-3 rounded-xl transition">
                Ver menú completo
            </a>
        </div>
    </div>
</section>
@endif

{{-- Categorías --}}
@if($categories->count())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">Explorá por categoría</h2>
        <p class="text-center text-gray-500 mb-10">Cada categoría es una especialidad de cocina diferente</p>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach($categories as $cat)
            <a href="{{ route('menu') }}" class="bg-orange-50 hover:bg-orange-100 border border-orange-200 text-orange-700 font-semibold px-6 py-3 rounded-full transition">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Roles informativos --}}
<section class="py-16 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-4">Una plataforma, múltiples roles</h2>
        <p class="text-center text-gray-400 mb-12">EatHidden conecta a todos los actores del ecosistema dark kitchen</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gray-800 rounded-2xl p-6 text-center">
                <div class="text-4xl mb-3">⚙️</div>
                <h3 class="font-semibold text-orange-400 mb-2">Administrador</h3>
                <p class="text-gray-400 text-sm">Gestiona usuarios, menú, categorías y reportes.</p>
            </div>
            <div class="bg-gray-800 rounded-2xl p-6 text-center">
                <div class="text-4xl mb-3">👨‍🍳</div>
                <h3 class="font-semibold text-orange-400 mb-2">Personal de cocina</h3>
                <p class="text-gray-400 text-sm">Recibe pedidos y actualiza su estado en tiempo real.</p>
            </div>
            <div class="bg-gray-800 rounded-2xl p-6 text-center">
                <div class="text-4xl mb-3">📱</div>
                <h3 class="font-semibold text-orange-400 mb-2">Cliente</h3>
                <p class="text-gray-400 text-sm">Explora el menú, hace pedidos y hace seguimiento.</p>
            </div>
            <div class="bg-gray-800 rounded-2xl p-6 text-center">
                <div class="text-4xl mb-3">🛵</div>
                <h3 class="font-semibold text-orange-400 mb-2">Repartidor</h3>
                <p class="text-gray-400 text-sm">Recibe asignaciones y gestiona sus entregas.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-orange-500 text-white text-center">
    <div class="max-w-2xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4">¿Listo para pedir?</h2>
        <p class="text-orange-100 mb-8">Creá tu cuenta y hacé tu primer pedido en minutos.</p>
        <div class="flex flex-wrap justify-center gap-4">
            @auth
                <a href="{{ route('orders.menu') }}" class="bg-white text-orange-500 hover:bg-orange-50 font-bold px-8 py-3 rounded-xl transition">
                    Ir al menú
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-orange-500 hover:bg-orange-50 font-bold px-8 py-3 rounded-xl transition">
                    Crear cuenta gratis
                </a>
                <a href="{{ route('login') }}" class="border-2 border-white hover:bg-orange-600 font-bold px-8 py-3 rounded-xl transition">
                    Iniciar sesión
                </a>
            @endauth
        </div>
    </div>
</section>

@endsection
