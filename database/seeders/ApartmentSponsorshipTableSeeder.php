<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsorship;

class ApartmentSponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 10; $i++){
            $apartment = Apartment::inRandomOrder()->first();

            $sponsorship = Sponsorship::inRandomOrder()->first();

            $apartment->sponsorships()->syncWithoutDetaching($sponsorship->id);
        }
    }
}
