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

    public function getSalesByMonth(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|date_format:m',
            'year' => 'required|integer|between:1900,2100',
        ]);

        $monthYear = $validated['year'] . '-' . $validated['month'];

        $salesData = Order::getTotalCakeSoldPerMonth($monthYear);

        if ($salesData->isEmpty()) {
            $response['success'] = false;
            $response['message'] = 'Tidak ada data penjualan untuk bulan ini.';
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }

        $totalSold = 0;
        $formattedSales = [];
        foreach ($salesData as $sale) {
            $totalSold += $sale->total;
            $formattedSales[] = [
                'cake_name' => $sale->cake->name,
                'size' => $sale->size,
                'total_sold' => $sale->total,
            ];
        }

        $response['success'] = true;
        $response['total_sold'] = $totalSold;
        $response['sales_details'] = $formattedSales;
        return response()->json($response, Response::HTTP_OK);
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
            'status' => 'required|in:pending,shipped,delivered,cancelled',
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

