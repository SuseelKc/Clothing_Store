<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $table='cart';
    protected $fillable = [
        'product_id',
        'rate',
        'color',
        'price',
        'image',
        'quantity',
        'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
