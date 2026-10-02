<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! app()->environment('local', 'testing')) {
            throw new RuntimeException('Demo data can only be seeded in local or testing environments.');
        }

        $this->call([
            UserSeeder::class,
            VehicleSeeder::class
        ]);
    }
}
