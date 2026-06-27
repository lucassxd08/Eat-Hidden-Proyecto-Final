@extends('layouts.app')
@section('title', 'Elige tu restaurante')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-white">¿De dónde quieres pedir?</h1>
        <p class="text-gray-500 mt-2">Elige un restaurante para ver su menú</p>
    </div>

    @if($restaurants->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <p class="text-xl">No hay restaurantes disponibles en este momento.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($restaurants as $restaurant)
            @php
                $texto = strtolower($restaurant->name . ' ' . $restaurant->description);
                if (str_contains($texto, 'burger') || str_contains($texto, 'hamburgues')) {
                    $emoji = '🍔'; $bg = 'bg-orange-900';
                } elseif (str_contains($texto, 'pizza')) {
                    $emoji = '🍕'; $bg = 'bg-red-900';
                } elseif (str_contains($texto, 'ramen') || str_contains($texto, 'noodle') || str_contains($texto, 'asiat')) {
                    $emoji = '🍜'; $bg = 'bg-yellow-900';
                } elseif (str_contains($texto, 'taco') || str_contains($texto, 'mexic') || str_contains($texto, 'burrito')) {
                    $emoji = '🌮'; $bg = 'bg-green-900';
                } elseif (str_contains($texto, 'sushi') || str_contains($texto, 'japan')) {
                    $emoji = '🍣'; $bg = 'bg-pink-900';
                } elseif (str_contains($texto, 'pollo') || str_contains($texto, 'chicken')) {
                    $emoji = '🍗'; $bg = 'bg-amber-900';
                } else {
                    $emoji = '🍽️'; $bg = 'bg-zinc-800';
                }
            @endphp
            <a href="{{ route('orders.menu', $restaurant) }}"
               class="bg-zinc-900 rounded-xl shadow hover:shadow-lg transition-all hover:scale-[1.02] p-6 flex flex-col gap-3 border border-zinc-700 hover:border-red-500 group">
                <div class="w-16 h-16 {{ $bg }} rounded-full flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                    {{ $emoji }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">{{ $restaurant->name }}</h2>
                    @if($restaurant->description)
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($restaurant->description, 80) }}</p>
                    @endif
                </div>
                <div class="flex items-center justify-between mt-auto pt-3 border-t border-zinc-700">
                    <span class="text-sm text-gray-400">{{ $restaurant->dishes_count }} platos disponibles</span>
                    <span class="text-red-500 font-semibold text-sm">Ver menú →</span>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
