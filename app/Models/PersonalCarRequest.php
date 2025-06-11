<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalCarRequest extends Model
{
    use HasFactory;

protected $fillable = [
    'name',
    'phone',    
    'position',
    'department',
    'car_brand',
    'car_registration',
    'seats',
    'destination',
    'province',
    'purpose',
    'start_time',
    'end_time',
    'reason',
    'attachment',
    'status',
];

}