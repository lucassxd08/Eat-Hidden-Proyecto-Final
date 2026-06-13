@extends('layouts.app')
@section('title', 'Elegí tu restaurante')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800">¿De dónde querés pedir?</h1>
        <p class="text-gray-500 mt-2">Elegí un restaurante para ver su menú</p>
    </div>

    @if($restaurants->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <p class="text-xl">No hay restaurantes disponibles en este momento.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($restaurants as $restaurant)
            <a href="{{ route('orders.menu', $restaurant) }}"
               class="bg-white rounded-xl shadow hover:shadow-lg transition-shadow p-6 flex flex-col gap-3 border border-transparent hover:border-red-300">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center text-3xl">
                    🍽️
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">{{ $restaurant->name }}</h2>
                    @if($restaurant->description)
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($restaurant->description, 80) }}</p>
                    @endif
                </div>
                <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
                    <span class="text-sm text-gray-400">{{ $restaurant->dishes_count }} platos disponibles</span>
                    <span class="text-red-500 font-semibold text-sm">Ver menú →</span>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
