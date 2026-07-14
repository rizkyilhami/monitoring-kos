<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's users.
     */
    public function run(): void
    {
        User::query()->truncate();

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'room' => null,
        ]);

        User::create([
            'name' => 'Penghuni Kamar 1',
            'email' => 'kamar1@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'room' => 1,
        ]);

        User::create([
            'name' => 'Penghuni Kamar 2',
            'email' => 'kamar2@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'room' => 2,
        ]);

        User::create([
            'name' => 'Penghuni Kamar 3',
            'email' => 'kamar3@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'room' => 3,
        ]);

        User::create([
            'name' => 'Penghuni Kamar 4',
            'email' => 'kamar4@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'room' => 4,
        ]);
    }
}
