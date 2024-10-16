<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Service;

class ApartmentServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 50; $i++){
            $apartment = Apartment::inRandomOrder()->first();

            $service_id = Service::inRandomOrder()->first()->id;

            $apartment->services()->attach($service_id);
        }
    }
}
