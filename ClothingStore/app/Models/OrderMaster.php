<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
