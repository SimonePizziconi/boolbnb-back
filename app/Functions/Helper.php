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
        return $address = $address . ' ' . $city . ' ' . $cap;
    }

    public static function convertAddressForQuery($address){
        return strtolower(urlencode($address));
    }

    public static function getApi($address){
        $apiUrl = 'https://api.tomtom.com/search/2/geocode/';
        $apiKey = '?key=d0Xq2xNT1UVJmJOO7pFoBBiHcFLGGy2Q';

       return $respone = file_get_contents($apiUrl .$address. '.json'. $apiKey);
    }
}
