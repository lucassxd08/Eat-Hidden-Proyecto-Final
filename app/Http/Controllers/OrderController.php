<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function restaurants()
    {
        $restaurants = Restaurant::where('active', true)->withCount('dishes')->get();
        return view('orders.restaurants', compact('restaurants'));
    }

    public function menu(Restaurant $restaurant)
    {
        $dishes = $restaurant->dishes()
            ->where('available', true)
            ->with('category')
            ->get()
            ->groupBy('category.name');

        return view('orders.menu', compact('restaurant', 'dishes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'            => 'required|array|min:1',
            'items.*.dish_id'  => 'required|exists:dishes,id',
            'items.*.quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string|max:255',
            'notes'            => 'nullable|string|max:500',
            'payment_method'   => 'required|in:Card,Yape',
        ]);

        $total = 0;
        $lines = [];

        foreach ($request->items as $item) {
            $dish      = Dish::findOrFail($item['dish_id']);
            $subtotal  = $dish->price * $item['quantity'];
            $total    += $subtotal;
            $lines[]   = [
                'dish_id'    => $dish->id,
                'quantity'   => $item['quantity'],
                'unit_price' => $dish->price,
            ];
        }

        $order = Order::create([
            'client_id'        => auth()->id(),
            'status'           => 'pending',
            'total'            => $total,
            'delivery_address' => $request->delivery_address,
            'notes'            => $request->notes,
            'metodo_pago'      => $request->payment_method,
            'estado_pago'      => $request->payment_method === 'Yape' ? 'Pendiente' : null,
            'fecha_pago'       => now(),
        ]);

        foreach ($lines as $line) {
            $order->items()->create($line);
        }

        $message = $request->payment_method === 'Yape'
            ? '¡Pedido realizado! Tu pago con Yape está pendiente de confirmación.'
            : '¡Pedido realizado! Pago con tarjeta registrado.';

        return redirect()->route('orders.show', $order)->with('success', $message);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items.dish', 'deliveryPerson');

        return view('orders.show', compact('order'));
    }

    public function index()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->get();
        return view('orders.index', compact('orders'));
    }
}
