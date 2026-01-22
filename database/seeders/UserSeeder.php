<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // sample Admin
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        // sample Petugas
        $petugas = \App\Models\User::create([
            'name' => 'Sample Petugas',
            'email' => 'petugas@example.com',
            'password' => bcrypt('password'),
            'role' => 'petugas'
        ]);
    }
}