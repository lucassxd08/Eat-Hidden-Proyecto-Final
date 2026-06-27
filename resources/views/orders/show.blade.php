@extends('layouts.app')
@section('title', 'Pedido #' . $order->id)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-red-500 hover:underline text-sm">&larr; Mis pedidos</a>
        <h1 class="text-3xl font-bold text-white mt-2">Boleta de pago</h1>
        <p class="text-gray-400 mt-1">Generada automáticamente después de completar el pedido.</p>
    </div>

<<<<<<< HEAD
    <div class="bg-zinc-900 rounded-2xl shadow p-8 space-y-6">
        {{-- Estado --}}
        <div class="flex items-center justify-between">
=======
    <div class="bg-gray-800 rounded-3xl shadow-xl p-8 space-y-6 border border-gray-700">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
>>>>>>> ad37690 (Fix order receipt view and cast fecha_pago to datetime)
            <div>
                <p class="text-sm text-gray-400 uppercase tracking-wide">Número de boleta</p>
                <p class="text-2xl font-bold text-white">#{{ $order->id }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-400 uppercase tracking-wide">Fecha</p>
                <p class="text-white font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
<<<<<<< HEAD
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
            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$order->status] ?? 'bg-zinc-900 text-gray-400' }}">
                {{ $order->status_label }}
            </span>
        </div>

        <hr class="border-zinc-700">

        {{-- Detalles --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Fecha</p>
                <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
=======
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-300">
            <div class="bg-gray-900 rounded-2xl p-4 border border-gray-700">
                <p class="text-gray-500 uppercase tracking-wide text-xs">Cliente</p>
                <p class="font-medium text-white">{{ $order->client->name }}</p>
                <p class="mt-2 text-gray-400">{{ $order->delivery_address }}</p>
>>>>>>> ad37690 (Fix order receipt view and cast fecha_pago to datetime)
            </div>
            <div class="bg-gray-900 rounded-2xl p-4 border border-gray-700 space-y-2">
                <div>
                    <p class="text-gray-500 uppercase tracking-wide text-xs">Método de pago</p>
                    <p class="font-medium text-white">{{ $order->metodo_pago === 'Yape' ? 'Yape' : 'Tarjeta' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 uppercase tracking-wide text-xs">Estado de pago</p>
                    <p class="font-medium text-white">{{ $order->estado_pago ?? ($order->metodo_pago === 'Yape' ? 'Pendiente' : 'Pagado') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 uppercase tracking-wide text-xs">Fecha de pago</p>
                    <p class="font-medium text-white">{{ optional($order->fecha_pago)->format('d/m/Y H:i') ?? $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

<<<<<<< HEAD
        <hr class="border-zinc-700">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Método de pago</p>
                <p class="font-medium">{{ $order->metodo_pago ?? 'Efectivo' }}</p>
            </div>
            @if($order->metodo_pago === 'Yape')
            <div>
                <p class="text-gray-500">Estado de pago</p>
                <p class="font-medium">{{ $order->estado_pago ?? 'Pendiente' }}</p>
            </div>
            @endif
=======
        @if($order->notes)
        <div class="bg-gray-900 rounded-2xl p-4 border border-gray-700 text-sm text-gray-300">
            <p class="text-gray-500 uppercase tracking-wide text-xs">Notas del pedido</p>
            <p class="mt-2">{{ $order->notes }}</p>
>>>>>>> ad37690 (Fix order receipt view and cast fecha_pago to datetime)
        </div>
        @endif

<<<<<<< HEAD
        <hr class="border-zinc-700">

        {{-- Items --}}
        <div>
            <h2 class="font-bold text-white mb-3">Detalle del pedido</h2>
            <table class="w-full text-sm">
                <thead class="text-gray-500 border-b border-zinc-700">
                    <tr>
                        <th class="pb-2 text-left">Plato</th>
                        <th class="pb-2 text-center">Cant.</th>
                        <th class="pb-2 text-right">Precio unit.</th>
                        <th class="pb-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
=======
        <div class="bg-gray-900 rounded-3xl border border-gray-700 overflow-hidden">
            <div class="px-6 py-4 bg-gray-950 text-gray-400 uppercase tracking-wide text-xs font-semibold">Detalle de la boleta</div>
            <table class="w-full text-sm text-gray-300">
                <thead>
                    <tr class="bg-gray-900 text-left text-gray-500 uppercase text-xs tracking-wider">
                        <th class="px-6 py-3">Plato</th>
                        <th class="px-6 py-3 text-center">Cantidad</th>
                        <th class="px-6 py-3 text-right">Precio unit.</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 bg-gray-800">
>>>>>>> ad37690 (Fix order receipt view and cast fecha_pago to datetime)
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4">{{ $item->dish->name }}</td>
                        <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-right">S/ {{ number_format($item->unit_price, 2) }}</td>
                        <td class="px-6 py-4 text-right font-medium text-white">S/ {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-900 text-gray-300">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-semibold">Subtotal</td>
                        <td class="px-6 py-4 text-right">S/ {{ number_format($order->total, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-semibold">Impuestos (0%)</td>
                        <td class="px-6 py-4 text-right">S/ 0.00</td>
                    </tr>
                    <tr class="border-t border-gray-700">
                        <td colspan="3" class="px-6 py-4 text-right font-bold text-white text-lg">Total</td>
                        <td class="px-6 py-4 text-right font-bold text-red-500 text-lg">S/ {{ number_format($order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-400">Esta boleta fue generada automáticamente al procesar tu pedido.</p>
            <button onclick="window.print()"
                    class="inline-flex items-center justify-center rounded-full bg-red-500 px-5 py-3 text-sm font-semibold text-white hover:bg-red-600 transition">
                Imprimir boleta
            </button>
        </div>
    </div>
</div>
@endsection

