<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Diki Ramdani',
            'role' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123')
        ]);

        // Manager
        User::create([
            'name' => 'Desti Oksa Viali',
            'role' => 'manager',
            'email' => 'dviali@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
