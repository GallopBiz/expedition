<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'role' => 'Manager',
        ]);

        User::factory()->create([
            'name' => 'Expeditor User',
            'email' => 'expeditor@example.com',
            'password' => bcrypt('password'),
            'role' => 'Expeditor',
        ]);

        User::factory()->create([
            'name' => 'Supplier User',
            'email' => 'supplier@example.com',
            'password' => bcrypt('password'),
            'role' => 'Supplier',
        ]);
    }
}
