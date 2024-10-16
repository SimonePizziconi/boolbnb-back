<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
USE App\Models\Apartment;
use Illuminate\Support\Facades\DB;
use App\Functions\Helper;
use App\Models\User;

class ApartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments = config('apartments');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($apartments as $apartment) {
            $new_aparment = new Apartment();
            $new_aparment->user_id = User::inRandomOrder()->first()->id;
            $new_aparment->title = $apartment['title'];
            $new_aparment->slug =
                Helper::generateSlug($new_aparment->title, Apartment::class);
            $new_aparment->rooms = $apartment['rooms'];
            $new_aparment->beds = $apartment['beds'];
            $new_aparment->bathrooms = $apartment['bathrooms'];
            $new_aparment->square_meters = $apartment['square_meters'];
            $new_aparment->address = $apartment['address'];
            $new_aparment->latitude = $apartment['latitude'];
            $new_aparment->longitude = $apartment['longitude'];
            $new_aparment->image_path = $apartment['image_path'];
            $new_aparment->image_original_name = $apartment['image_original_name'];
            $new_aparment->is_visible = $apartment['is_visible'] ?? 1;
            $new_aparment->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        }
    }
}
