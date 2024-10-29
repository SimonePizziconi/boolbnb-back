<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Sponsorship;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class,
            ServiceTableSeeder::class,
            SponsorshipTableSeeder::class,
            ApartmentTableSeeder::class,
            ApartmentSponsorshipTableSeeder::class,
            ApartmentServiceTableSeeder::class,
            StatisticTableSeeder::class,
            MessageTableSeeder::class,
        ]);
    }
}
