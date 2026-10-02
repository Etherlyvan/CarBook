<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => 'admin'],
        );

        User::updateOrCreate(
            ['email' => 'approver@example.com'],
            ['name' => 'Approver', 'password' => Hash::make('password'), 'role' => 'approver'],
        );
        User::updateOrCreate(
            ['email' => 'approver2@example.com'],
            ['name' => 'Approver 2', 'password' => Hash::make('password'), 'role' => 'approver'],
        );
    }
}
