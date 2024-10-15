<?php

namespace App\Functions;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Helper {

    public static function generateSlug($string, $model){
        $slug = Str::slug($string, '-');
        $original_slug = $slug;

        $exists = $model::where('slug', $slug)->first();
        $c = 1;

        while($exists){
            $slug = $original_slug . '-' . $c;
            $exists = $model::where('slug', $slug)->first();
            $c++;
        }

        return $slug;

    }

    public static function getFullAddress($address, $city, $cap){
        return $address = $address . ', ' . $city . ', ' . $cap;
    }

}
