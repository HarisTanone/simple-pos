<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Ahmad Pelayan',
                'email' => 'pelayan@test.com',
                'password' => Hash::make('password'),
                'role' => UserRole::PELAYAN,
            ],
            [
                'name' => 'Budi Pelayan',
                'email' => 'pelayan2@test.com',
                'password' => Hash::make('password'),
                'role' => UserRole::PELAYAN,
            ],
            [
                'name' => 'Siti Kasir',
                'email' => 'kasir@test.com',
                'password' => Hash::make('password'),
                'role' => UserRole::KASIR,
            ],
            [
                'name' => 'Desi Kasir',
                'email' => 'kasir2@test.com',
                'password' => Hash::make('password'),
                'role' => UserRole::KASIR,
            ]
        ]);
    }
}
