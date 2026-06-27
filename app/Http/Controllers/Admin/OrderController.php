<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('client', 'items.dish')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivering,delivered,cancelled',
        ]);

        try {
            $order->update(['status' => $request->status]);
            return back()->with('success', 'Estado del pedido actualizado.');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo actualizar el estado. Intente nuevamente.');
        }
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'estado_pago' => 'required|in:Pendiente,Pagado,Rechazado',
        ]);

        try {
            $status = match ($request->estado_pago) {
                'Pagado'    => 'confirmed',
                'Rechazado' => 'cancelled',
                default     => $order->status,
            };

            $order->update([
                'estado_pago' => $request->estado_pago,
                'fecha_pago'  => $order->fecha_pago ?? now(),
                'status'      => $status,
            ]);

            return back()->with('success', 'Estado de pago actualizado.');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo actualizar el estado de pago. Intente nuevamente.');
        }
    }
}
