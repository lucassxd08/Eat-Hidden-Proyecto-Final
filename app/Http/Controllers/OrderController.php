<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function menu()
    {
        $categories = Category::where('active', true)
            ->with(['dishes' => fn($q) => $q->where('available', true)])
            ->get();

        return view('orders.menu', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'            => 'required|array|min:1',
            'items.*.dish_id'  => 'required|exists:dishes,id',
            'items.*.quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string|max:255',
            'notes'            => 'nullable|string|max:500',
        ]);

        $total = 0;
        $lines = [];

        foreach ($request->items as $item) {
            $dish = Dish::findOrFail($item['dish_id']);
            $subtotal = $dish->price * $item['quantity'];
            $total += $subtotal;
            $lines[] = [
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
        ]);

        foreach ($lines as $line) {
            $order->items()->create($line);
        }

        return redirect()->route('orders.show', $order)->with('success', '¡Pedido realizado con éxito!');
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
