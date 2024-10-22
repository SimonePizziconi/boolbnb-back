<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;


class PageController extends Controller
{
    public function index()
    {
        $apartments = Apartment::where('is_visible', true)->orderBy('id', 'desc')->with('services')->get();

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

    public function services(){
        $services = Service::all();

        return response()->json(compact('services'));
    }

    public function show($slug){

        $apartment = Apartment::where('slug', $slug)->where('is_visible', true)->with('services')->first();

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
        $rooms = $request->get('rooms', 1);
        $beds = $request->get('beds', 1);
        $servicesIds = $request->get('services', []);

        // Query per filtrare gli appartamenti entro il raggio specificato
        $apartments = Apartment::select('*')
            ->selectRaw(
                "( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance",
                [$lat, $lng, $lat]
            )
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->where('rooms', '>=', $rooms)
            ->where('beds', '>=', $beds)
            ->with('services');
            // Aggiunge il filtro per i servizi se ci sono ID specificati
            if (!empty($servicesIds)) {
                $apartments->whereHas('services', function ($query) use ($servicesIds) {
                    $query->whereIn('services.id', $servicesIds);
                });
            }

            $apartments = $apartments->get();

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

        $count = $apartments->count();

        return response()->json(compact('success', 'apartments', 'count'));
    }
}
