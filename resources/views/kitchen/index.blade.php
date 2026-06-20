@extends('layouts.app')
@section('title', 'Panel de Cocina')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-white mb-2">Panel de Cocina</h1>
    <p class="text-gray-500 mb-8">Pedidos activos que requieren atención</p>

    @forelse($orders as $order)
    @php
        $statusColors = [
            'pending'   => 'bg-yellow-900 text-yellow-300 border-yellow-800',
            'confirmed' => 'bg-blue-900 text-blue-300 border-blue-800',
            'preparing' => 'bg-red-900 text-red-300 border-red-800',
            'ready'     => 'bg-green-900 text-green-300 border-green-800',
        ];
        $color = $statusColors[$order->status] ?? 'bg-gray-800 text-gray-300 border-gray-700';
    @endphp
    <div class="bg-gray-800 rounded-2xl shadow mb-6 overflow-hidden border-l-4 {{ str_contains($color, 'yellow') ? 'border-yellow-400' : (str_contains($color, 'blue') ? 'border-blue-400' : (str_contains($color, 'orange') ? 'border-red-400' : 'border-green-400')) }}">
        <div class="p-6">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="font-bold text-xl text-white">Pedido #{{ $order->id }}</h2>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm mt-1">
                        Cliente: <strong>{{ $order->client->name }}</strong> ·
                        {{ $order->created_at->format('H:i') }} hs ·
                        {{ $order->items->count() }} plato(s)
                    </p>
                    @if($order->notes)
                        <p class="text-gray-500 text-sm mt-1">Nota: <em>{{ $order->notes }}</em></p>
                    @endif
                </div>

                <form method="POST" action="{{ route('kitchen.update-status', $order) }}" class="flex items-center gap-2">
                    @csrf @method('PATCH')
                    <select name="status" class="border border-gray-600 rounded-lg px-3 py-2 bg-gray-900 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                        @if($order->status === 'pending')
                            <option value="confirmed">Confirmar</option>
                            <option value="cancelled">Cancelar</option>
                        @elseif($order->status === 'confirmed')
                            <option value="preparing">Iniciar preparación</option>
                        @elseif($order->status === 'preparing')
                            <option value="ready">Marcar como listo</option>
                        @endif
                    </select>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        Actualizar
                    </button>
                </form>
            </div>

            <div class="mt-4 border-t pt-4">
                <table class="w-full text-sm">
                    <thead class="text-gray-500">
                        <tr>
                            <th class="text-left pb-2">Plato</th>
                            <th class="text-center pb-2">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr class="border-t border-gray-700">
                            <td class="py-1.5">{{ $item->dish->name }}</td>
                            <td class="py-1.5 text-center font-semibold">{{ $item->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-20">
        <div class="text-6xl mb-4">✅</div>
        <p class="text-xl text-gray-500">No hay pedidos activos en este momento.</p>
    </div>
    @endforelse
</div>
@endsection

