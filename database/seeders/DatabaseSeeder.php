<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Mouhcine',
            'email' => 'mouhcine@local.test',
            'password' => Hash::make('p@ssword'),
        ]);

        $this->call(ProductSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
