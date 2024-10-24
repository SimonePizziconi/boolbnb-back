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
        for ($i = 0; $i < 50; $i++) {
            // Seleziona un appartamento casuale
            $apartment = Apartment::inRandomOrder()->first();

            // Seleziona un servizio casuale
            $service = Service::inRandomOrder()->first();

            // Usa syncWithoutDetaching per evitare duplicati
            $apartment->services()->syncWithoutDetaching($service->id);
        }
    }
}
