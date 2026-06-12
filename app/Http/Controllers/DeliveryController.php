<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        $orders = Order::whereIn('status', ['ready', 'delivering'])
            ->where(function ($q) {
                $q->whereNull('delivery_id')->orWhere('delivery_id', auth()->id());
            })
            ->with('items.dish', 'client')
            ->latest()
            ->get();

        return view('delivery.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:delivering,delivered',
        ]);

        $data = ['status' => $request->status];
        if ($request->status === 'delivering' && !$order->delivery_id) {
            $data['delivery_id'] = auth()->id();
        }

        $order->update($data);

        return back()->with('success', 'Estado del pedido actualizado.');
    }
}
