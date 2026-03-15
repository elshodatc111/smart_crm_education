<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder{

    public function run(): void{
        User::create([
            'role' => 'admin',
            'name' => 'Admin',
            'phone' => '+998901234567',
            'password' => '12345678',
            'is_active' => true
        ]);
        User::create([
            'role' => 'director',
            'name' => 'Director',
            'phone' => '+998901230001',
            'password' => '12345678',
            'is_active' => true
        ]);
        User::create([
            'role' => 'manager',
            'name' => 'Manager',
            'phone' => '+998901230002',
            'password' => '12345678',
            'is_active' => true
        ]);
        User::create([
            'role' => 'operator',
            'name' => 'Operator',
            'phone' => '+998901230003',
            'password' => '12345678',
            'is_active' => true
        ]);
        User::create([
            'role' => 'user',
            'name' => 'User',
            'phone' => '+998901230004',
            'password' => '12345678',
            'is_active' => true
        ]);
    }
}
