<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('cake')->get();
        $data['success'] = true;
        $data['result'] = $orders;
        return response()->json($data, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
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
        $order = Order::with('cake')->find($id);
        if ($order) {
            $response['success'] = true;
            $response['result'] = $order;
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = 'Order tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'customer_name' => 'required|string',
            'customer_address' => 'required|string',
            'delivery_date' => 'required|date',
            'payment_method' => 'required|in:cashless,cash',
        ]);

        $order = Order::where('id', $id)->update($validate);
        if ($order) {
            $response['success'] = true;
            $response['message'] = 'Order berhasil diperbarui.';
            $response['result'] = Order::with('cake')->find($id);
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = 'Order tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validate = $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);

        $order = Order::find($id);
        if ($order) {
            $order->update(['status' => $validate['status']]);
            $response['success'] = true;
            $response['message'] = 'Status order berhasil diperbarui.';
            $response['result'] = $order;
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = 'Order tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $order = Order::where('id', $id);
        if ($order->exists()) {
            $order->delete();
            $response['success'] = true;
            $response['message'] = 'Order berhasil dihapus.';
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response['success'] = false;
            $response['message'] = 'Order tidak ditemukan.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
}
