<?php

namespace Database\Seeders;

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

            // Controlla se l'appartamento ha già una sponsorizzazione attiva
            $activeSponsorship = $apartment->sponsorships()
                ->wherePivot('end_date', '>', Carbon::now())
                ->first();

            // Se esiste una sponsorizzazione attiva, estendila
            if ($activeSponsorship) {
                $newEndDate = Carbon::parse($activeSponsorship->pivot->end_date)
                    ->addHours($sponsorship->duration);

                $apartment->sponsorships()->updateExistingPivot($activeSponsorship->id, [
                    'end_date' => $newEndDate,
                ]);
            } else {
                // Altrimenti, imposta una nuova sponsorizzazione
                $startDate = Carbon::now();
                $endDate = $startDate->copy()->addHours($sponsorship->duration);

                $apartment->sponsorships()->attach($sponsorship->id, [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            }
        }
    }
}
