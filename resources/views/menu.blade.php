@extends('layouts.app')
@section('title', 'Restaurantes')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-white mb-2">Nuestros Restaurantes</h1>
    <p class="text-gray-500 mb-10">Elige una dark kitchen y explora su menú</p>

    @if($restaurants->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($restaurants as $restaurant)
            <div class="bg-gray-800 rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
                <div class="bg-red-50 h-36 flex items-center justify-center text-5xl">🍽️</div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-white">{{ $restaurant->name }}</h3>
                    @if($restaurant->description)
                        <p class="text-gray-500 text-sm mt-1">{{ $restaurant->description }}</p>
                    @endif
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-gray-400 text-sm">{{ $restaurant->dishes_count }} platos</span>
                        @auth
                            <a href="{{ route('orders.menu', $restaurant) }}" class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg transition">
                                Ver menú
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg transition">
                                Iniciar sesión
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 text-gray-400">
            <div class="text-6xl mb-4">🏪</div>
            <p class="text-xl">No hay restaurantes disponibles en este momento.</p>
        </div>
    @endif
</div>
@endsection
