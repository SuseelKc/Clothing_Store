<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
