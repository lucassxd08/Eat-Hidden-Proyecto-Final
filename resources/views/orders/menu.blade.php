@extends('layouts.app')
@section('title', 'Menú — ' . $restaurant->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('orders.restaurants') }}" class="text-red-500 hover:underline text-sm">← Volver a restaurantes</a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $restaurant->name }}</h1>
            @if($restaurant->description)
                <p class="text-gray-500 text-sm">{{ $restaurant->description }}</p>
            @endif
        </div>
    </div>

    @if($dishes->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <p class="text-xl">Este restaurante no tiene platos disponibles.</p>
        </div>
    @else
    <form action="{{ route('orders.store') }}" method="POST" id="order-form">
        @csrf

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Menú --}}
            <div class="flex-1 space-y-8">
                @foreach($dishes as $categoryName => $categoryDishes)
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">{{ $categoryName ?? 'Sin categoría' }}</h2>
                    <div class="space-y-3">
                        @foreach($categoryDishes as $dish)
                        <div class="bg-white rounded-xl shadow-sm p-4 flex justify-between items-center gap-4">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $dish->name }}</p>
                                @if($dish->description)
                                    <p class="text-sm text-gray-500">{{ $dish->description }}</p>
                                @endif
                                <p class="text-red-500 font-bold mt-1">S/ {{ number_format($dish->price, 2) }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="changeQty({{ $dish->id }}, -1)"
                                        class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 font-bold text-lg leading-none">−</button>
                                <span id="qty-{{ $dish->id }}" class="w-6 text-center font-semibold">0</span>
                                <button type="button" onclick="changeQty({{ $dish->id }}, 1)"
                                        class="w-8 h-8 rounded-full bg-red-500 hover:bg-red-600 text-white font-bold text-lg leading-none">+</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Carrito --}}
            <div class="w-full lg:w-80">
                <div class="bg-white rounded-xl shadow p-5 sticky top-4">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Tu pedido</h2>

                    <div id="cart-items" class="space-y-2 mb-4 min-h-[60px]">
                        <p id="cart-empty" class="text-gray-400 text-sm">Agregá platos para comenzar.</p>
                    </div>

                    <div class="border-t pt-3 mb-4">
                        <div class="flex justify-between font-bold text-gray-800">
                            <span>Total</span>
                            <span>S/ <span id="cart-total">0.00</span></span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">💵 Pago en efectivo al repartidor</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección de entrega *</label>
                            <input type="text" name="delivery_address" required
                                   value="{{ auth()->user()->address }}"
                                   placeholder="Tu dirección completa"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notas (opcional)</label>
                            <textarea name="notes" rows="2" placeholder="Sin cebolla, extra salsa..."
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>
                        </div>
                    </div>

                    <div id="cart-inputs"></div>

                    <button type="submit" id="submit-btn" disabled
                            class="w-full mt-4 bg-red-500 hover:bg-red-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3 rounded-lg transition-colors">
                        Realizar Pedido
                    </button>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>

<script>
const prices = {
    @foreach($dishes->flatten() as $dish)
    {{ $dish->id }}: {{ $dish->price }},
    @endforeach
};
const names = {
    @foreach($dishes->flatten() as $dish)
    {{ $dish->id }}: "{{ addslashes($dish->name) }}",
    @endforeach
};
const quantities = {};

function changeQty(id, delta) {
    quantities[id] = Math.max(0, (quantities[id] || 0) + delta);
    document.getElementById('qty-' + id).textContent = quantities[id];
    updateCart();
}

function updateCart() {
    let total = 0;
    let html = '';
    let inputsHtml = '';
    let index = 0;

    for (const [id, qty] of Object.entries(quantities)) {
        if (qty > 0) {
            const subtotal = prices[id] * qty;
            total += subtotal;
            html += `<div class="flex justify-between text-sm text-gray-700">
                        <span>${names[id]} x${qty}</span>
                        <span>S/ ${subtotal.toFixed(2)}</span>
                     </div>`;
            inputsHtml += `<input type="hidden" name="items[${index}][dish_id]" value="${id}">
                           <input type="hidden" name="items[${index}][quantity]" value="${qty}">`;
            index++;
        }
    }

    const cartEmpty = document.getElementById('cart-empty');
    const cartItems = document.getElementById('cart-items');
    cartEmpty.style.display = html ? 'none' : 'block';
    cartItems.innerHTML = html + cartEmpty.outerHTML;
    document.getElementById('cart-inputs').innerHTML = inputsHtml;
    document.getElementById('cart-total').textContent = total.toFixed(2);
    document.getElementById('submit-btn').disabled = index === 0;
}
</script>
@endsection
