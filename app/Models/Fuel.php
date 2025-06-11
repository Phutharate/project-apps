<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'fuel_order_number',
        'receipt_number',
        'license_plate',
        'start_km',
        'distance',
        'fuel_liters',
        'amount_spent',
        'issued_by',
        'receiver',
        'remark',
    ];
}
