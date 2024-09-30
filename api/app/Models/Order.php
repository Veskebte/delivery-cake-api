<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cake_id',
        'customer_name',
        'customer_address',
        'status',
        'delivery_date',
        'payment_method',
    ];

    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }

    public static function getTotalCakeSoldPerMonth($month)
    {
        return self::with('cake')
            ->select('cake_id', 'size', DB::raw('SUM(quantity) as total'))
            ->whereYear('delivery_date', date('Y', strtotime($month)))
            ->whereMonth('delivery_date', date('m', strtotime($month)))
            ->groupBy('cake_id', 'size')
            ->get();
    }
}