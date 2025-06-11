<?php

namespace Database\Seeders;

use App\Models\User;
use Directory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AdminUserSeeder::class,
            ChiefSeeder::class,
            UserSeeder::class,
            DriverSeeder::class,
            DirectorUserSeeder::class,
        ]);
    }
}
