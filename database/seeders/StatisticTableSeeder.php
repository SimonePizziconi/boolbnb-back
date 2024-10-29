<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use Faker\Factory as Faker;
use App\Models\Statistic;
use Illuminate\Support\Carbon;
class StatisticTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {
        $faker = Faker::create();
        $apartmentIds = Apartment::pluck('id')->toArray();

        // Calcoliamo la data di inizio, 12 mesi indietro rispetto a oggi
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();

        foreach ($apartmentIds as $apartmentId) {
            // Genera visualizzazioni per ciascun mese dal mese di inizio fino a oggi
            for ($month = 0; $month < 12; $month++) {
                $currentMonth = $startDate->copy()->addMonths($month);
                $viewsPerMonth = rand(20, 100);

                for ($i = 0; $i < $viewsPerMonth; $i++) {
                    Statistic::withoutTimestamps(function () use ($apartmentId, $faker, $currentMonth) {
                        Statistic::create([
                            'apartment_id' => $apartmentId,
                            'ip_address' => $faker->ipv4,
                            'created_at' => $currentMonth->copy()->day(rand(1, 28)),
                            'updated_at' => now(),
                        ]);
                    });
                }
            }
        }
    }
}
