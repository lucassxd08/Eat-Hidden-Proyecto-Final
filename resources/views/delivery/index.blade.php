@extends('layouts.app')
@section('title', 'Entregas')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-white mb-2">Panel de Entregas</h1>
    <p class="text-gray-500 mb-8">Elige un pedido listo para recoger o gestiona los que ya tienes en camino</p>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @forelse($orders as $order)
    @php
        $isMine = $order->delivery_id === auth()->id();
        $colorMap = [
            'ready'      => ['bg-green-900 text-green-300', 'border-green-400'],
            'delivering' => ['bg-indigo-900 text-indigo-300', 'border-indigo-400'],
        ];
        [$badgeColor, $borderColor] = $colorMap[$order->status] ?? ['bg-gray-800 text-gray-400', 'border-gray-600'];
    @endphp
    <div class="bg-gray-800 rounded-2xl shadow mb-6 border-l-4 {{ $borderColor }} overflow-hidden">
        <div class="p-6">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h2 class="font-bold text-xl">Pedido #{{ $order->id }}</h2>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                            {{ $order->status_label }}
                        </span>
                        @if($isMine)
                            <span class="px-2 py-1 rounded-full text-xs bg-red-900 text-red-300 font-semibold">Tu pedido</span>
                        @endif
                    </div>
                    <p class="text-gray-500 text-sm mt-2">
                        Cliente: <strong>{{ $order->client->name }}</strong>
                    </p>
                    <p class="text-gray-400 text-sm mt-0.5">
                        Dirección: <strong>{{ $order->delivery_address }}</strong>
                    </p>
                    @if($order->notes)
                        <p class="text-gray-500 text-sm mt-0.5">Notas: {{ $order->notes }}</p>
                    @endif
                    <p class="text-red-500 font-bold mt-2">S/ {{ number_format($order->total, 2) }} — 💵 Cobrar en efectivo</p>

                    {{-- Items del pedido --}}
                    <div class="mt-3 space-y-1">
                        @foreach($order->items as $item)
                            <p class="text-sm text-gray-400">• {{ $item->quantity }}x {{ $item->dish->name }}</p>
                        @endforeach
                    </div>
                </div>

                <div>
                    @if($order->status === 'ready')
                        <form method="POST" action="{{ route('delivery.update-status', $order) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="delivering">
                            <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition">
                                Tomar y salir a entregar
                            </button>
                        </form>
                    @elseif($order->status === 'delivering' && $isMine)
                        <form method="POST" action="{{ route('delivery.update-status', $order) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="delivered">
                            <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition">
                                Marcar como entregado
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-20">
        <div class="text-6xl mb-4">🛵</div>
        <p class="text-xl text-gray-500">No hay entregas pendientes en este momento.</p>
    </div>
    @endforelse
</div>
@endsection
