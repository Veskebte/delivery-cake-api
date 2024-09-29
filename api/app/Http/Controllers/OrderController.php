<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cake;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with('cake')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'delivery_date' => 'required|date',
            'payment_method' => 'required|in:cashless,cash',
        ]);

        $order = Order::create($request->all());

        return Order::with('cake')->find($order->id);
    }

    public function show($id)
    {
        return Order::with('cake')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return Order::with('cake')->find($id);
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return response()->noContent();
    }
}

