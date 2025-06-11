<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChiefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'chief@example.com')->exists()) {
            User::create([
                'name' => 'Chief',
                'email' => 'chief@example.com',
                'password' => Hash::make('22222'),
                'role' => 'chief',
                'email_verified_at' => now(),
            ]);
        };
    }
}
