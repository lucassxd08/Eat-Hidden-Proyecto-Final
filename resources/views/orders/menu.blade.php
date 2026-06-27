@extends('layouts.app')
@section('title', 'Menú — ' . $restaurant->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('orders.restaurants') }}" class="text-red-500 hover:underline text-sm">← Volver a restaurantes</a>
        <div>
            <h1 class="text-2xl font-bold text-white">{{ $restaurant->name }}</h1>
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
                    <h2 class="text-lg font-semibold text-gray-300 mb-3 border-b border-zinc-700 pb-2">{{ $categoryName ?? 'Sin categoría' }}</h2>
                    <div class="space-y-3">
                        @foreach($categoryDishes as $dish)
                        <div class="bg-zinc-900 rounded-xl shadow-sm p-4 flex justify-between items-center gap-4">
                            <div class="flex-1">
                                <p class="font-semibold text-white">{{ $dish->name }}</p>
                                @if($dish->description)
                                    <p class="text-sm text-gray-500">{{ $dish->description }}</p>
                                @endif
                                <p class="text-red-500 font-bold mt-1">S/ {{ number_format($dish->price, 2) }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="changeQty({{ $dish->id }}, -1)"
                                        class="w-8 h-8 rounded-full bg-zinc-800 hover:bg-zinc-700 font-bold text-lg leading-none">−</button>
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
                <div class="bg-zinc-900 rounded-xl shadow p-5 sticky top-4">
                    <h2 class="text-lg font-bold text-white mb-4">Tu pedido</h2>

                    <div id="cart-items" class="space-y-2 mb-4 min-h-[60px]">
                        <p id="cart-empty" class="text-gray-400 text-sm">Agrega platos para comenzar.</p>
                    </div>

                    <div class="border-t pt-3 mb-4">
                        <div class="flex justify-between font-bold text-white">
                            <span>Total</span>
                            <span>S/ <span id="cart-total">0.00</span></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-400 mt-2">
                            <span>Método de pago</span>
                            <span id="selected-payment-method">Tarjeta</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Dirección de entrega *</label>
                            <input type="text" name="delivery_address" required
                                   value="{{ auth()->user()->address }}"
                                   placeholder="Tu dirección completa"
                                   class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Notas (opcional)</label>
                            <textarea name="notes" rows="2" placeholder="Sin cebolla, extra salsa..."
                                      class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Método de pago</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm text-gray-300">
                                    <input type="radio" name="payment_method" value="Card" checked>
                                    Tarjeta
                                </label>
                                <label class="flex items-center gap-2 text-sm text-gray-300">
                                    <input type="radio" name="payment_method" value="Yape">
                                    Yape
                                </label>
                            </div>
                        </div>

                        <div id="card-payment-section" class="rounded-xl border border-zinc-700 bg-zinc-950/70 p-3 space-y-3">
                            <div class="text-sm text-gray-300 space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Número de tarjeta</label>
                                <input type="text" name="card_number" inputmode="numeric" maxlength="19" placeholder="1234 5678 9012 3456"
                                       class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                                <label class="block text-sm font-medium text-gray-300">Nombre del titular</label>
                                <input type="text" name="card_name" placeholder="Juan Pérez"
                                       class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300">Fecha de expiración</label>
                                        <input type="text" name="card_expiry" placeholder="MM/AA"
                                               class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300">CVV</label>
                                        <input type="password" name="card_cvv" maxlength="4" placeholder="***"
                                               class="w-full border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-950 text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="yape-payment-section" class="hidden rounded-xl border border-zinc-700 bg-zinc-950/70 p-3 space-y-3">
                            <div class="text-center">
<<<<<<< HEAD
                                <img src="{{ asset('images/yape-qr.jpg') }}" alt="Código QR de Yape" class="mx-auto rounded-lg border border-zinc-700 max-h-48 object-contain">
=======
                                <img id="yape-qr-code" src="{{ asset('images/yape-qr.jpg') }}" alt="Código QR de Yape" class="mx-auto rounded-lg border border-gray-700 max-h-48 object-contain">
>>>>>>> ad37690 (Fix order receipt view and cast fecha_pago to datetime)
                            </div>
                            <div class="text-sm text-gray-300 space-y-1">
                                <p class="font-semibold text-white">Monto total: S/ <span id="payment-total">0.00</span></p>
                                <p>Escanea el código QR con la aplicación Yape y realiza el pago usando tu cuenta de Yape.</p>
                            </div>
                        </div>
                    </div>

                    <div id="cart-inputs"></div>

                    <button type="submit" id="submit-btn" disabled
                            class="w-full mt-4 bg-red-500 hover:bg-red-600 disabled:bg-zinc-800 disabled:text-gray-500 disabled:cursor-not-allowed text-white font-bold py-3 rounded-lg transition-colors">
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
const categories = {
    @foreach($dishes as $categoryName => $categoryDishes)
    @foreach($categoryDishes as $dish)
    {{ $dish->id }}: "{{ addslashes($categoryName ?? 'Sin categoría') }}",
    @endforeach
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
            html += `<div class="flex justify-between text-sm text-gray-300 gap-2">
                        <span class="flex-1 min-w-0">
                            <span class="text-xs text-red-400 font-medium">${categories[id]}</span>
                            <span class="block truncate">${names[id]} x${qty}</span>
                        </span>
                        <span class="shrink-0 font-medium">S/ ${subtotal.toFixed(2)}</span>
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
    document.getElementById('payment-total').textContent = total.toFixed(2);
    document.getElementById('selected-payment-method').textContent = document.querySelector('input[name="payment_method"]:checked')?.value === 'Yape' ? 'Yape' : 'Tarjeta';

    // Usamos el QR real de Yape desde public/images/yape-qr.jpg.
    // No lo reemplazamos con un QR genérico automático.
    document.getElementById('submit-btn').disabled = index === 0;
}

const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
const cardSection = document.getElementById('card-payment-section');
const yapeSection = document.getElementById('yape-payment-section');

function togglePaymentSections() {
    const selected = document.querySelector('input[name="payment_method"]:checked')?.value;
    cardSection.classList.toggle('hidden', selected !== 'Card');
    yapeSection.classList.toggle('hidden', selected !== 'Yape');
}

paymentMethodRadios.forEach((radio) => {
    radio.addEventListener('change', togglePaymentSections);
});

togglePaymentSections();
updateCart();
</script>
@endsection
