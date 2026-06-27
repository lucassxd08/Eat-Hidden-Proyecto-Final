@extends('layouts.app')
@section('title', 'Pedido #' . $order->id)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-red-500 hover:underline text-sm">&larr; Mis pedidos</a>
        <h1 class="text-3xl font-bold text-white mt-2">Pedido #{{ $order->id }}</h1>
    </div>

    <div class="bg-gray-800 rounded-2xl shadow p-8 space-y-6">
        {{-- Estado --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Estado actual</p>
                <p class="text-xl font-bold text-white mt-1">{{ $order->status_label }}</p>
            </div>
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
            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-800 text-gray-400' }}">
                {{ $order->status_label }}
            </span>
        </div>

        <hr>

        {{-- Detalles --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Fecha</p>
                <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Dirección de entrega</p>
                <p class="font-medium">{{ $order->delivery_address }}</p>
            </div>
            @if($order->notes)
            <div class="sm:col-span-2">
                <p class="text-gray-500">Notas</p>
                <p class="font-medium">{{ $order->notes }}</p>
            </div>
            @endif
            @if($order->deliveryPerson)
            <div>
                <p class="text-gray-500">Repartidor</p>
                <p class="font-medium">{{ $order->deliveryPerson->name }}</p>
            </div>
            @endif
        </div>

        <hr>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Método de pago</p>
                <p class="font-medium">{{ $order->metodo_pago === 'Yape' ? 'Yape' : 'Tarjeta' }}</p>
            </div>
            @if($order->metodo_pago === 'Yape')
            <div>
                <p class="text-gray-500">Estado de pago</p>
                <p class="font-medium">{{ $order->estado_pago ?? 'Pendiente' }}</p>
            </div>
            @endif
        </div>

        <hr>

        {{-- Items --}}
        <div>
            <h2 class="font-bold text-white mb-3">Detalle del pedido</h2>
            <table class="w-full text-sm">
                <thead class="text-gray-500 border-b">
                    <tr>
                        <th class="pb-2 text-left">Plato</th>
                        <th class="pb-2 text-center">Cant.</th>
                        <th class="pb-2 text-right">Precio unit.</th>
                        <th class="pb-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="py-2">{{ $item->dish->name }}</td>
                        <td class="py-2 text-center">{{ $item->quantity }}</td>
                        <td class="py-2 text-right">S/ {{ number_format($item->unit_price, 2) }}</td>
                        <td class="py-2 text-right font-medium">S/ {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t">
                    <tr>
                        <td colspan="3" class="pt-3 text-right font-bold text-white">Total</td>
                        <td class="pt-3 text-right font-bold text-red-500 text-lg">S/ {{ number_format($order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

