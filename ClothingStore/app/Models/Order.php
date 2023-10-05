<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table='order';
    protected $fillable = [
        'user_id',
        'product_id',
        'order_master_id',
        'quantity',
        'rate',
        'amount',
        'image'
    ];
    public function orderMaster()
    {
        return $this->belongsTo(OrderMaster::class, 'order_master_id');
    }
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    
}
