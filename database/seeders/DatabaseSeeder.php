<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan TIDAK ADA pemanggilan User::factory() di sini

        User::create([
            'username' => 'admin',
            'gmail'    => 'admin@smkn5.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);
    }
}
