<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'cake_id',
        'customer_name',
        'customer_address',
        'status',
        'delivery_date', 
        'payment_method',
        'size', // Pastikan ada kolom size untuk menyimpan ukuran kue
        'quantity', // Tambahkan kolom quantity (jumlah beli)
    ];

    // Relasi dengan model Cake
    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }

    // Method untuk mendapatkan total kue yang terjual per tanggal tertentu
    public function getTotalCakeSoldPerDate($date)
    {
        return self::whereDate('delivery_date', $date)->sum('quantity'); // Menghitung total pesanan di tanggal tertentu
    }

    // Method untuk mendapatkan total penjualan per bulan dengan detail kue dan ukuran
    public static function getTotalCakeSoldPerMonth($month)
    {
        // Query untuk mendapatkan total kue yang terjual per bulan berdasarkan cake_id, ukuran, dan quantity
        return self::with('cake')  // Memuat relasi cake agar bisa mendapatkan nama kue
            ->select('cake_id', 'size', DB::raw('SUM(quantity) as total')) // Mengelompokkan berdasarkan cake_id, ukuran, dan menghitung jumlah total
            ->whereYear('delivery_date', date('Y', strtotime($month))) // Filter berdasarkan tahun
            ->whereMonth('delivery_date', date('m', strtotime($month))) // Filter berdasarkan bulan
            ->groupBy('cake_id', 'size')  // Mengelompokkan berdasarkan cake_id dan ukuran
            ->get();
    }
}
