<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderMaster extends Model
{
    use HasFactory;
    protected $table='order_master';

    protected $fillable=[
        'user_id',
        'purchasecode',
        'totalamount',
        'delivery_status',
        'payment_type'
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'order_master_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
