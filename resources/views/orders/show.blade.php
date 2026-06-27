@extends('layouts.app')
@section('title', 'Boleta #' . $order->id)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-red-500 hover:underline text-sm">&larr; Mis pedidos</a>
        <h1 class="text-3xl font-bold text-white mt-2">Boleta de pago</h1>
        <p class="text-gray-400 mt-1">Generada automáticamente después de completar el pedido.</p>
    </div>

    <div class="bg-zinc-900 rounded-3xl shadow-xl p-8 space-y-6 border border-zinc-700">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-gray-400 uppercase tracking-wide">Número de boleta</p>
                <p class="text-2xl font-bold text-white">#{{ $order->id }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-400 uppercase tracking-wide">Fecha</p>
                <p class="text-white font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-300">
            <div class="bg-zinc-950 rounded-2xl p-4 border border-zinc-700">
                <p class="text-gray-500 uppercase tracking-wide text-xs">Cliente</p>
                <p class="font-medium text-white">{{ $order->client->name }}</p>
                <p class="mt-2 text-gray-400">{{ $order->delivery_address }}</p>
            </div>
            <div class="bg-zinc-950 rounded-2xl p-4 border border-zinc-700 space-y-2">
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

        @if($order->notes)
        <div class="bg-zinc-950 rounded-2xl p-4 border border-zinc-700 text-sm text-gray-300">
            <p class="text-gray-500 uppercase tracking-wide text-xs">Notas del pedido</p>
            <p class="mt-2">{{ $order->notes }}</p>
        </div>
        @endif

        <div class="bg-zinc-950 rounded-3xl border border-zinc-700 overflow-hidden">
            <div class="px-6 py-4 bg-black text-gray-400 uppercase tracking-wide text-xs font-semibold">Detalle de la boleta</div>
            <table class="w-full text-sm text-gray-300">
                <thead>
                    <tr class="bg-zinc-950 text-left text-gray-500 uppercase text-xs tracking-wider">
                        <th class="px-6 py-3">Plato</th>
                        <th class="px-6 py-3 text-center">Cantidad</th>
                        <th class="px-6 py-3 text-right">Precio unit.</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4">{{ $item->dish->name }}</td>
                        <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-right">S/ {{ number_format($item->unit_price, 2) }}</td>
                        <td class="px-6 py-4 text-right font-medium text-white">S/ {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-zinc-950 text-gray-300">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-semibold">Subtotal</td>
                        <td class="px-6 py-4 text-right">S/ {{ number_format($order->total, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-semibold">Impuestos (0%)</td>
                        <td class="px-6 py-4 text-right">S/ 0.00</td>
                    </tr>
                    <tr class="border-t border-zinc-700">
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
