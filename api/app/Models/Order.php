<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'payment_method'
    ];

    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }
}


