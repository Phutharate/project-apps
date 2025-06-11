<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',              // ชื่อรถ หรือจะเปลี่ยนตามตารางจริงในฐานข้อมูล
        'car_registration',  // เลขทะเบียนรถ
        'car_image',
        // ใส่ฟิลด์อื่นๆ ตามที่คุณมีในตาราง vehicles
    ];
}
