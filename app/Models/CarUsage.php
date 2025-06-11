<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarUsage extends Model
{
        protected $fillable = [
            'sequence', 'date', 'time', 'user_name', 'destination',
            'start_mileage', 'end_mileage', 'total_distance',
            'driver_name', 'return_date', 'return_time', 'notes',
        ];

}

