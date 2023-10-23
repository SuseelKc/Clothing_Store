<?php

namespace App\Models;

use App\Models\Products;
use App\Models\ProductImage;
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
    public function productImage(){
        return $this->hasmany(ProductImage::class,'product_id','product_id');
    }

}
