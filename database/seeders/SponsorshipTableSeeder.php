<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Functions\Helper;
use App\Models\Sponsorship;

class SponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsorships = [
            [
                'name' => 'Basic',
                'current_price' => 19.99,
                'duration' => 24,
            ],
            [
                'name' => 'Standard',
                'current_price' => 39.99,
                'duration' => 72,
            ],
            [
                'name' => 'Premium',
                'current_price' => 79.99,
                'duration' => 168,
            ]
        ];

        foreach ($sponsorships as $sponsorship) {
            $new_sponsorship = new Sponsorship();
            $new_sponsorship->name = $sponsorship['name'];
            $new_sponsorship->slug = Helper::generateSlug($sponsorship['name'], Sponsorship::class);
            $new_sponsorship->current_price = $sponsorship['current_price'];
            $new_sponsorship->duration = $sponsorship['duration'];

            $new_sponsorship->save();
        }
    }
}
