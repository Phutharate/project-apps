<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'user@example.com')->exists()) {
            User::create([
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('22222'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
        }
    }
}
