<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TowingPrice;

class TowingPriceSeeder extends Seeder
{
    public function run(): void
    {
        $prices = [
            // Saloon
            ['vehicle_type' => 'Saloon', 'min_distance' => 0,  'max_distance' => 10, 'price' => 4000],
            ['vehicle_type' => 'Saloon', 'min_distance' => 10, 'max_distance' => 20, 'price' => 5000],
            ['vehicle_type' => 'Saloon', 'min_distance' => 20, 'max_distance' => 30, 'price' => 6500],
            ['vehicle_type' => 'Saloon', 'min_distance' => 30, 'max_distance' => 40, 'price' => 8000],
            ['vehicle_type' => 'Saloon', 'min_distance' => 40, 'max_distance' => 50, 'price' => 10000],

            // SUV
            ['vehicle_type' => 'SUV', 'min_distance' => 0,  'max_distance' => 10, 'price' => 4500],
            ['vehicle_type' => 'SUV', 'min_distance' => 10, 'max_distance' => 20, 'price' => 5500],
            ['vehicle_type' => 'SUV', 'min_distance' => 20, 'max_distance' => 30, 'price' => 7000],
            ['vehicle_type' => 'SUV', 'min_distance' => 30, 'max_distance' => 40, 'price' => 8500],
            ['vehicle_type' => 'SUV', 'min_distance' => 40, 'max_distance' => 50, 'price' => 10500],

            // Pickup
            ['vehicle_type' => 'Pickup', 'min_distance' => 0,  'max_distance' => 10, 'price' => 4500],
            ['vehicle_type' => 'Pickup', 'min_distance' => 10, 'max_distance' => 20, 'price' => 5500],
            ['vehicle_type' => 'Pickup', 'min_distance' => 20, 'max_distance' => 30, 'price' => 7000],
            ['vehicle_type' => 'Pickup', 'min_distance' => 30, 'max_distance' => 40, 'price' => 8500],
            ['vehicle_type' => 'Pickup', 'min_distance' => 40, 'max_distance' => 50, 'price' => 10500],

            // Van
            ['vehicle_type' => 'Van', 'min_distance' => 0,  'max_distance' => 10, 'price' => 5000],
            ['vehicle_type' => 'Van', 'min_distance' => 10, 'max_distance' => 20, 'price' => 6000],
            ['vehicle_type' => 'Van', 'min_distance' => 20, 'max_distance' => 30, 'price' => 7500],
            ['vehicle_type' => 'Van', 'min_distance' => 30, 'max_distance' => 40, 'price' => 9000],
            ['vehicle_type' => 'Van', 'min_distance' => 40, 'max_distance' => 50, 'price' => 11000],

            // Truck
            ['vehicle_type' => 'Truck', 'min_distance' => 0,  'max_distance' => 10, 'price' => 7000],
            ['vehicle_type' => 'Truck', 'min_distance' => 10, 'max_distance' => 20, 'price' => 8500],
            ['vehicle_type' => 'Truck', 'min_distance' => 20, 'max_distance' => 30, 'price' => 10000],
            ['vehicle_type' => 'Truck', 'min_distance' => 30, 'max_distance' => 40, 'price' => 12000],
            ['vehicle_type' => 'Truck', 'min_distance' => 40, 'max_distance' => 50, 'price' => 14000],
        ];

        foreach ($prices as $price) {
            TowingPrice::create($price);
        }
    }
}
