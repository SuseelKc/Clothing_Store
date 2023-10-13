<?php

namespace App\Models;

use App\Models\Address;
use App\Models\OrderMaster;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $table='address';
    protected $fillable = [
        'user_id',
        'street',
        'state',
        'city',
        'country',
        'contact_name',
        'contact_no',
        'address_name',
        'type',
    ];
    public function ordermaster()
    {
        return $this->belongsTo(Address::class);
    }
}
