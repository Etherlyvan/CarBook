<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        Vehicle::create([
            'name' => 'Truck A',
            'type' => 'Truck',
            'is_company_owned' => true,
            'fuel_consumption' => 15.0,
        ]);

        Vehicle::create([
            'name' => 'Car B',
            'type' => 'Car',
            'is_company_owned' => false,
            'fuel_consumption' => 10.0,
        ]);
    }
}
