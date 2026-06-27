@extends('layouts.app')
@section('title', 'Gestión de Pedidos')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white">Pedidos</h1>
        <p class="text-gray-400 mt-1">Gestión y seguimiento de todos los pedidos</p>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-20 text-gray-500">
            <p class="text-xl">No hay pedidos registrados.</p>
        </div>
    @else
    <div class="bg-gray-800 rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-900 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">Pedido</th>
                    <th class="px-6 py-4 text-left">Cliente</th>
                    <th class="px-6 py-4 text-left">Platos</th>
                    <th class="px-6 py-4 text-right">Total</th>
                    <th class="px-6 py-4 text-center">Pago</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-center">Actualizar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($orders as $order)
                @php
                    $statusColors = [
                        'pending'    => 'bg-yellow-900 text-yellow-300',
                        'confirmed'  => 'bg-blue-900 text-blue-300',
                        'preparing'  => 'bg-orange-900 text-orange-300',
                        'ready'      => 'bg-green-900 text-green-300',
                        'delivering' => 'bg-indigo-900 text-indigo-300',
                        'delivered'  => 'bg-green-800 text-green-200',
                        'cancelled'  => 'bg-red-900 text-red-300',
                    ];
                @endphp
                <tr class="hover:bg-gray-700">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-white">#{{ $order->id }}</p>
                        <p class="text-gray-500 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-white">{{ $order->client->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $order->delivery_address }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-400">
                        @foreach($order->items as $item)
                            <p class="text-xs">{{ $item->dish->name }} x{{ $item->quantity }}</p>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-red-400">
                        S/ {{ number_format($order->total, 2) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="space-y-1">
                            <p class="text-xs text-gray-500">Método</p>
                            <p class="text-sm font-medium text-white">{{ $order->metodo_pago ?? 'Efectivo' }}</p>
                            <p class="text-xs text-gray-500">Estado</p>
                            <p class="text-sm font-medium text-white">{{ $order->estado_pago ?? '—' }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-700 text-gray-300' }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="space-y-2">
                            @if(!in_array($order->status, ['delivered', 'cancelled']))
                            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="flex items-center justify-center gap-2">
                                @csrf @method('PATCH')
                                <select name="status" class="border border-gray-600 rounded-lg px-2 py-1 bg-gray-900 text-white text-xs focus:outline-none focus:ring-1 focus:ring-red-500">
                                    <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmed"  {{ $order->status === 'confirmed'  ? 'selected' : '' }}>Confirmado</option>
                                    <option value="preparing"  {{ $order->status === 'preparing'  ? 'selected' : '' }}>Preparando</option>
                                    <option value="ready"      {{ $order->status === 'ready'      ? 'selected' : '' }}>Listo</option>
                                    <option value="delivering" {{ $order->status === 'delivering' ? 'selected' : '' }}>En camino</option>
                                    <option value="delivered"  {{ $order->status === 'delivered'  ? 'selected' : '' }}>Entregado</option>
                                    <option value="cancelled"  {{ $order->status === 'cancelled'  ? 'selected' : '' }}>Cancelado</option>
                                </select>
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    OK
                                </button>
                            </form>
                            @else
                                <span class="text-gray-600 text-xs">—</span>
                            @endif

                            @if($order->metodo_pago === 'Yape')
                            <form method="POST" action="{{ route('admin.orders.update-payment-status', $order) }}" class="flex items-center justify-center gap-2">
                                @csrf @method('PATCH')
                                <select name="estado_pago" class="border border-gray-600 rounded-lg px-2 py-1 bg-gray-900 text-white text-xs focus:outline-none focus:ring-1 focus:ring-red-500">
                                    <option value="Pendiente" {{ $order->estado_pago === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Pagado" {{ $order->estado_pago === 'Pagado' ? 'selected' : '' }}>Pagado</option>
                                    <option value="Rechazado" {{ $order->estado_pago === 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                                <button type="submit" class="bg-gray-700 hover:bg-gray-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    Pago
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
