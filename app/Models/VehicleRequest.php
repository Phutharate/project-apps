<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Vehicle;


class VehicleRequest extends Model
{
    use HasFactory;

    protected $table = 'car_requests';

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'driver', // เป็นชื่อ ไม่ใช่ ID
        'destination',
        'start_time',
        'end_time',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //public function driver()
    //{
     //   return $this->belongsTo(User::class, 'driver');
    //}

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
