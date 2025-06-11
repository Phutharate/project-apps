<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    // ✅ เพิ่มตรงนี้เพื่อให้ Laravel อนุญาตให้บันทึกค่าพวกนี้
    protected $fillable = [
        'prefix',
        'first_name',
        'last_name',
        'gender',
        'position',
        'user_group',
        'registered_at',
        'role'
    ];

    protected $casts = [
        'registered_at' => 'date',
    ];
}
