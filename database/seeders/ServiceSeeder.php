<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Car Wash', 'default_amount' => 15.00, 'icon' => 'Car Wash', 'is_active' => true],
            ['name' => 'Polish', 'default_amount' => 120.00, 'icon' => 'Polish', 'is_active' => true],
            ['name' => 'Tinted', 'default_amount' => 350.00, 'icon' => 'Tinted', 'is_active' => true],
            ['name' => 'Other', 'default_amount' => 0.00, 'icon' => 'Other', 'is_active' => true],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }
    }
}
