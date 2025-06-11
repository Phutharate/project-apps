<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'email',
        'status',
        'password', // ถ้าคุณต้องการเก็บ password
    ];
}
