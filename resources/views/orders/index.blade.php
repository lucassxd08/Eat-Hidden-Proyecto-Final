@extends('layouts.app')
@section('title', 'Mis Pedidos')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white">Mis pedidos</h1>
        <a href="{{ route('orders.restaurants') }}" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2.5 rounded-lg transition">
            + Nuevo pedido
        </a>
    </div>

    @forelse($orders as $order)
    @php
        $statusColors = [
            'pending'    => 'bg-yellow-900 text-yellow-300',
            'confirmed'  => 'bg-blue-900 text-blue-300',
            'preparing'  => 'bg-red-900 text-red-300',
            'ready'      => 'bg-green-900 text-green-300',
            'delivering' => 'bg-indigo-900 text-indigo-300',
            'delivered'  => 'bg-green-800 text-green-200',
            'cancelled'  => 'bg-red-900 text-red-300',
        ];
    @endphp
    <div class="bg-zinc-900 rounded-2xl shadow mb-4 p-6 flex items-center justify-between">
        <div>
            <p class="font-bold text-white">Pedido #{{ $order->id }}</p>
            <p class="text-gray-500 text-sm mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p class="text-gray-500 text-sm">{{ $order->items->count() }} plato(s)</p>
        </div>
        <div class="text-right">
            <p class="font-bold text-red-500 text-lg">S/ {{ number_format($order->total, 2) }}</p>
            <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-zinc-900 text-gray-400' }}">
                {{ $order->status_label }}
            </span>
            <div class="mt-2">
                <a href="{{ route('orders.show', $order) }}" class="text-blue-400 hover:underline text-sm">Ver detalle</a>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-20">
        <div class="text-6xl mb-4">🛵</div>
        <p class="text-xl text-gray-500">Aún no tienes pedidos.</p>
        <a href="{{ route('orders.restaurants') }}" class="inline-block mt-4 bg-red-500 text-white font-semibold px-6 py-3 rounded-xl hover:bg-red-600 transition">
            Hacer mi primer pedido
        </a>
    </div>
    @endforelse
</div>
@endsection

