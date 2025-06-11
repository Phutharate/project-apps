<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = [
            [
                'name' => 'นายนัดทพง รวมวาปี',
                'email' => 'driver1@example.com',
                'code' => 'DRV001',
            ],
            [
                'name' => 'นายสธาวุท นันคำ',
                'email' => 'driver2@example.com',
                'code' => 'DRV002',
            ],
            [
                'name' => 'นายสมพุทธ นอก',
                'email' => 'driver3@example.com',
                'code' => 'DRV003',
            ],
            [
                'name' => 'นายพนักงาน ไหม่',
                'email' => 'driver4@example.com',
                'code' => 'DRV004',
            ],
        ];

        foreach ($drivers as $driver) {
            User::updateOrCreate(
                ['email' => $driver['email']],
                [
                    'name' => $driver['name'],
                    'password' => bcrypt('22222'), // รหัสผ่านเริ่มต้น
                    'role' => 'driver',
                    'code' => $driver['code'],
                ]
            );
        }
    }
}
