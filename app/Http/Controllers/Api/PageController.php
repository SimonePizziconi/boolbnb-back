<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\Storage;


class PageController extends Controller
{
    public function index()
    {
        $apartments = Apartment::orderBy('id', 'desc')->with('services')->get();

        if ($apartments) {
            $success = true;
            foreach ($apartments as $apartment) {
                if (!$apartment->image_path) {
                    $apartment->image_path = '/img/house-placeholder.jpg';
                    $apartment->image_original_name = 'no image';
                } else {
                    $apartment->image_path = Storage::url($apartment->image_path);
                }
            }
        } else {
            $success = false;
        }

        return response()->json(compact('success', 'apartments'));
    }

    public function show($slug){

        $apartment = Apartment::where('slug', $slug)->with('services')->first();

        if ($apartment) {
            $success = true;

            if (!$apartment->image_path) {
                $apartment->image_path = '/img/house-placeholder.jpg';
                $apartment->image_original_name = 'no image';
            } else {
                $apartment->image_path = Storage::url($apartment->image_path);
            }

        } else {
            $success = false;
        }

        return response()->json(compact('success','apartment'));
    }

    public function search(Request $request)
    {
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $radius = $request->get('radius', 20); // Valore di default a 20 km se non specificato

        // Query per filtrare gli appartamenti entro il raggio specificato
        $apartments = Apartment::select('*')
            ->selectRaw(
                "( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance",
                [$lat, $lng, $lat]
            )
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->with('services')
            ->get();

        if ($apartments->isEmpty()) {
            $success = false;
        } else {
            $success = true;
            foreach ($apartments as $apartment) {
                if (!$apartment->image_path) {
                    $apartment->image_path = '/img/house-placeholder.jpg';
                    $apartment->image_original_name = 'no image';
                } else {
                    $apartment->image_path = Storage::url($apartment->image_path);
                }
            }
        }

        return response()->json(compact('success', 'apartments'));
    }
}
