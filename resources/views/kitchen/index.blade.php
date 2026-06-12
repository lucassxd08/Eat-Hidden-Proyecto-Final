@extends('layouts.app')
@section('title', 'Panel de Cocina')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Panel de Cocina</h1>
    <p class="text-gray-500 mb-8">Pedidos activos que requieren atención</p>

    @forelse($orders as $order)
    @php
        $statusColors = [
            'pending'   => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'confirmed' => 'bg-blue-100 text-blue-700 border-blue-200',
            'preparing' => 'bg-orange-100 text-orange-700 border-orange-200',
            'ready'     => 'bg-green-100 text-green-700 border-green-200',
        ];
        $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
    @endphp
    <div class="bg-white rounded-2xl shadow mb-6 overflow-hidden border-l-4 {{ str_contains($color, 'yellow') ? 'border-yellow-400' : (str_contains($color, 'blue') ? 'border-blue-400' : (str_contains($color, 'orange') ? 'border-orange-400' : 'border-green-400')) }}">
        <div class="p-6">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="font-bold text-xl text-gray-900">Pedido #{{ $order->id }}</h2>
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
                    <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        @if($order->status === 'pending')
                            <option value="confirmed">Confirmar</option>
                            <option value="cancelled">Cancelar</option>
                        @elseif($order->status === 'confirmed')
                            <option value="preparing">Iniciar preparación</option>
                        @elseif($order->status === 'preparing')
                            <option value="ready">Marcar como listo</option>
                        @endif
                    </select>
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
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
                        <tr class="border-t border-gray-50">
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
