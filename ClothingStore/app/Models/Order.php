<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Products;
use App\Models\OrderMaster;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'image',
        'size_id'
    ];
    public function orderMaster()
    {
        return $this->belongsTo(OrderMaster::class, 'order_master_id');
    }
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    public function order_master()
    {
        return $this->belongsTo(OrderMaster::class);
    }
    public function productImage(){
        return $this->hasMany(ProductImage::class,'product_id','product_id');
    }
    public function sizes()
    {
        return $this->belongsTo(Sizes::class, 'size_id','id');
    }
   
}
