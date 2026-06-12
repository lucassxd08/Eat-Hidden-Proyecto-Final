<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index()
    {
        $orders = Order::whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->with('items.dish', 'client')
            ->latest()
            ->get();

        return view('kitchen.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,preparing,ready,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Estado del pedido actualizado.');
    }
}
