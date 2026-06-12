@extends('layouts.app')
@section('title', 'Mis Entregas')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Entregas</h1>
    <p class="text-gray-500 mb-8">Pedidos listos para recoger y en camino</p>

    @forelse($orders as $order)
    @php
        $colorMap = [
            'ready'      => ['bg-green-100 text-green-700', 'border-green-400'],
            'delivering' => ['bg-indigo-100 text-indigo-700', 'border-indigo-400'],
        ];
        [$badgeColor, $borderColor] = $colorMap[$order->status] ?? ['bg-gray-100 text-gray-600', 'border-gray-300'];
    @endphp
    <div class="bg-white rounded-2xl shadow mb-6 border-l-4 {{ $borderColor }} overflow-hidden">
        <div class="p-6">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="font-bold text-xl">Pedido #{{ $order->id }}</h2>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm mt-1">
                        Cliente: <strong>{{ $order->client->name }}</strong>
                    </p>
                    <p class="text-gray-600 text-sm mt-0.5">
                        Dirección: <strong>{{ $order->delivery_address }}</strong>
                    </p>
                    <p class="text-orange-500 font-bold mt-1">S/ {{ number_format($order->total, 2) }}</p>
                </div>

                <form method="POST" action="{{ route('delivery.update-status', $order) }}" class="flex items-center gap-2">
                    @csrf @method('PATCH')
                    <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        @if($order->status === 'ready')
                            <option value="delivering">Recoger y salir a entregar</option>
                        @elseif($order->status === 'delivering')
                            <option value="delivered">Marcar como entregado</option>
                        @endif
                    </select>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        Actualizar
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-20">
        <div class="text-6xl mb-4">🛵</div>
        <p class="text-xl text-gray-500">No hay entregas pendientes.</p>
    </div>
    @endforelse
</div>
@endsection
