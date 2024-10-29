<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Support\Carbon;

class ApartmentSponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $apartment = Apartment::inRandomOrder()->first();
            $sponsorship = Sponsorship::inRandomOrder()->first();

            // Imposta la data di inizio come data attuale
            $startDate = Carbon::now();

            // Calcola la data di fine aggiungendo la durata della sponsorizzazione
            $endDate = $startDate->copy()->addHours($sponsorship->duration);

            // Associa l'appartamento alla sponsorizzazione con le date
            $apartment->sponsorships()->attach($sponsorship->id, [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }
    }
}
