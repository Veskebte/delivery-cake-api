<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('cake')->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'delivery_date' => 'required|date',
            'payment_method' => 'required|in:credit_card,paypal,cash',
        ]);

        $order = Order::create($request->all());
        return response()->json($order);
    }

    public function show($id)
    {
        $order = Order::with('cake')->findOrFail($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'delivery_date' => 'required|date',
            'payment_method' => 'required|in:credit_card,paypal,cash',
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }

    // untuk ngubah pesanan
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return response()->json($order);
    }
}
