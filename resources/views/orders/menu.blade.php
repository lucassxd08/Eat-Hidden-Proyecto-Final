@extends('layouts.app')
@section('title', 'Hacer un pedido')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Hacer un pedido</h1>
    <p class="text-gray-500 mb-8">Seleccioná los platos que querés y completá tu pedido.</p>

    <form method="POST" action="{{ route('orders.store') }}" id="order-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Menú --}}
            <div class="lg:col-span-2 space-y-8">
                @forelse($categories as $category)
                    @if($category->dishes->count())
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b border-orange-200 pb-2">
                            {{ $category->name }}
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($category->dishes as $dish)
                            <div class="bg-white rounded-xl shadow p-4 flex gap-4 items-start">
                                <div class="bg-orange-50 rounded-lg w-16 h-16 flex items-center justify-center text-3xl flex-shrink-0">🍽</div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $dish->name }}</h3>
                                    @if($dish->description)
                                        <p class="text-gray-500 text-xs mt-0.5 line-clamp-2">{{ $dish->description }}</p>
                                    @endif
                                    <p class="text-orange-500 font-bold mt-1">S/ {{ number_format($dish->price, 2) }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="number"
                                        name="qty_{{ $dish->id }}"
                                        min="0" max="10" value="0"
                                        data-dish="{{ $dish->id }}"
                                        data-price="{{ $dish->price }}"
                                        data-name="{{ $dish->name }}"
                                        onchange="updateCart(this)"
                                        class="w-16 border border-gray-300 rounded-lg text-center text-sm py-1 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @empty
                    <p class="text-gray-400 text-center py-10">No hay platos disponibles.</p>
                @endforelse
            </div>

            {{-- Resumen del pedido --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow p-6 sticky top-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Tu pedido</h2>

                    <div id="cart-items" class="space-y-2 mb-4 min-h-[60px]">
                        <p class="text-gray-400 text-sm" id="empty-cart-msg">Aún no seleccionaste ningún plato.</p>
                    </div>

                    <div class="border-t pt-4 mb-4">
                        <div class="flex justify-between font-bold text-gray-900">
                            <span>Total</span>
                            <span id="cart-total">S/ 0.00</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección de entrega *</label>
                            <input type="text" name="delivery_address" value="{{ auth()->user()->address }}"
                                required placeholder="Ej: Av. Larco 123, Miraflores"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notas adicionales</label>
                            <textarea name="notes" rows="2" placeholder="Ej: sin cebolla, extra salsa..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                        </div>

                        <div id="hidden-items"></div>

                        <button type="submit" id="submit-btn" disabled
                            class="w-full bg-orange-500 hover:bg-orange-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3 rounded-xl transition">
                            Confirmar pedido
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
const cart = {};

function updateCart(input) {
    const dishId = input.dataset.dish;
    const price  = parseFloat(input.dataset.price);
    const name   = input.dataset.name;
    const qty    = parseInt(input.value) || 0;

    if (qty > 0) {
        cart[dishId] = { name, price, qty };
    } else {
        delete cart[dishId];
    }

    renderCart();
}

function renderCart() {
    const container  = document.getElementById('cart-items');
    const emptyMsg   = document.getElementById('empty-cart-msg');
    const hiddenArea = document.getElementById('hidden-items');
    const totalEl    = document.getElementById('cart-total');
    const submitBtn  = document.getElementById('submit-btn');

    container.innerHTML  = '';
    hiddenArea.innerHTML = '';

    let total = 0;
    let idx   = 0;

    if (Object.keys(cart).length === 0) {
        container.appendChild(document.createTextNode(''));
        emptyMsg && (emptyMsg.style.display = 'block');
        totalEl.textContent = 'S/ 0.00';
        submitBtn.disabled  = true;
        return;
    }

    if (emptyMsg) emptyMsg.style.display = 'none';

    for (const [dishId, item] of Object.entries(cart)) {
        const subtotal = item.price * item.qty;
        total += subtotal;

        const row = document.createElement('div');
        row.className = 'flex justify-between text-sm text-gray-700';
        row.innerHTML = `<span>${item.qty}x ${item.name}</span><span class="font-medium">S/ ${subtotal.toFixed(2)}</span>`;
        container.appendChild(row);

        const inp1 = document.createElement('input');
        inp1.type  = 'hidden';
        inp1.name  = `items[${idx}][dish_id]`;
        inp1.value = dishId;

        const inp2 = document.createElement('input');
        inp2.type  = 'hidden';
        inp2.name  = `items[${idx}][quantity]`;
        inp2.value = item.qty;

        hiddenArea.appendChild(inp1);
        hiddenArea.appendChild(inp2);
        idx++;
    }

    totalEl.textContent = `S/ ${total.toFixed(2)}`;
    submitBtn.disabled  = false;
}
</script>
@endsection
