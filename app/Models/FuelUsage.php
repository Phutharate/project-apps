<?php

// app/Models/FuelUsage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelUsage extends Model
{
    protected $fillable = [
        'date',
        'license_plate',
        'fuel_order_number',
        'receipt_number',
        'start_km',
        'end_km',
        'distance',
        'fuel_liters',
        'amount_baht',    // ✅ ถ้าใช้ 'amount_baht' แทนจริง ๆ คุณควรลบ amount_spent ออก
        'issued_by',
        'receiver',
        'remark',
    ];
}
