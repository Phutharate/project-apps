<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DirectorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'director@example.com')->exists()) {
            User::create([
                'name' => 'director',
                'email' => 'director@example.com',
                'password' => Hash::make('22222'),
                'role' => 'director',
                'email_verified_at' => now(),
            ]);
        };
    }
}
