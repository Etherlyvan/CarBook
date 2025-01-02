<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Approver',
            'email' => 'approver@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
        ]);
        User::create([
            'name' => 'Approver2',
            'email' => 'approver2@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
        ]);
    }
}
