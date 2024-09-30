<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        // Mendapatkan semua order beserta kue yang terkait
        return Order::with('cake')->get();
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'cake_id' => 'required|exists:cakes,id',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'delivery_date' => 'required|date',
            'payment_method' => 'required|in:cashless,cash',
            'size' => 'required|in:small,medium,large',
            'quantity' => 'required|integer|min:1' // Validasi untuk jumlah beli
        ]);

        // Simpan order baru
        $order = Order::create($request->all());

        // Return order yang telah disimpan beserta relasi cake
        return Order::with('cake')->find($order->id);
    }

    public function getSalesByDate(Request $request)
    {
        // Validasi input tanggal
        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        Log::info('Tanggal yang diterima: ' . $validated['date']);

        // Mendapatkan total kue terjual pada tanggal tertentu
        $orderModel = new Order(); 
        $totalCakes = $orderModel->getTotalCakeSoldPerDate($validated['date']);

        // Return data dalam bentuk JSON
        return response()->json([
            'date' => $validated['date'],
            'total_cakes_sold' => $totalCakes,
        ]);
    }

    // Method untuk mendapatkan penjualan kue per bulan dengan detail
    public function getSalesByMonth(Request $request)
    {
        // Validasi input bulan dan tahun
        $validated = $request->validate([
            'month' => 'required|date_format:m',
            'year' => 'required|integer|between:1900,2100', // Memvalidasi tahun
        ]);

        // Format bulan dan tahun menjadi format yang sesuai untuk query
        $monthYear = $validated['year'] . '-' . $validated['month'];

        // Mengambil data penjualan per bulan
        $salesData = Order::getTotalCakeSoldPerMonth($monthYear);

        if ($salesData->isEmpty()) {
            return response()->json([
                'month' => $monthYear,
                'message' => 'Tidak ada data penjualan untuk bulan ini.',
            ]);
        }

        // Format data untuk output
        $totalSold = 0;
        $formattedSales = [];
        foreach ($salesData as $sale) {
            $totalSold += $sale->total; // Menambah total penjualan
            $formattedSales[] = [
                'cake_name' => $sale->cake->name,  // Mengambil nama kue dari relasi cake
                'size' => $sale->size,
                'total_sold' => $sale->total, // Total jumlah kue terjual
            ];
        }

        // Return data dalam bentuk JSON
        return response()->json([
            'month' => $monthYear,
            'total_sold' => $totalSold, // Total kue terjual
            'sales_details' => $formattedSales,
        ]);
    }

    public function show($id)
    {
        // Menampilkan detail order berdasarkan id
        return Order::with('cake')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'cake_id' => 'sometimes|exists:cakes,id',
            'customer_name' => 'sometimes|string',
            'customer_address' => 'sometimes|string',
            'delivery_date' => 'sometimes|date',
            'payment_method' => 'sometimes|in:cashless,cash',
            'size' => 'sometimes|in:small,medium,large',
            'quantity' => 'sometimes|integer|min:1' // Validasi untuk jumlah beli
        ]);

        // Mengupdate order berdasarkan id
        $order = Order::findOrFail($id);
        $order->update($request->all());

        // Return order yang sudah diupdate beserta relasi cake
        return Order::with('cake')->find($id);
    }

    public function destroy($id)
    {
        // Menghapus order berdasarkan id
        Order::findOrFail($id)->delete();
        return response()->noContent();
    }
}
