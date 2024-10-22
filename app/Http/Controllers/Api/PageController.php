<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\Message;


class PageController extends Controller
{
    public function index()
    {
        $apartments = Apartment::where('is_visible', true)
            ->leftJoin('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->leftJoin('sponsorships', 'apartment_sponsorship.sponsorship_id', '=', 'sponsorships.id')
            ->select('apartments.*', 'apartment_sponsorship.end_date')
            ->orderBy('apartment_sponsorship.end_date', 'desc')
            ->with('services', 'sponsorships')
            ->get();

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

    public function services()
    {
        $services = Service::all();

        return response()->json(compact('services'));
    }

    public function show($slug)
    {

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

        return response()->json(compact('success', 'apartment'));
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

    public function getUser(){
        if(Auth::check()){
            $user = Auth::user()->email;
        }else{
            $user = 'utente non loggato';
        }

        return response()->json(compact('user'));
    }

    public function message(Request $request, $slug){

        $data = $request->all();

        $validator = Validator::make($data,
            [
                'first_name' => 'required|min:3|regex:/^[a-zA-Z\s]+$/',
                'last_name' => 'required|min:3|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required', 'string', 'lowercase', 'email', 'max:255',
                'message' => 'required|min:10',
            ],
            [
                'first_name.required' => 'Il campo nome è obbligatorio',
                'first_name.min' => 'Il campo nome deve contenere almeno :min caratteri',
                'first_name.regex' => 'Il campo nome non può contenere numeri o caratteri speciali',

                'last_name.required' => 'Il campo cognome è obbligatorio',
                'last_name.min' => 'Il campo cognome deve contenere almeno :min caratteri',
                'last_name.regex' => 'Il campo cognome non può contenere numeri o caratteri speciali',

                'email.required' => 'Il campo email è obbligatorio',
                'email.string' => 'Il campo email deve essere una stringa',
                'email.lowercase' => 'Il campo email non può contenere lettere maiuscole',
                'email.email' => 'Il campo email deve essere un indirizzo email valido',
                'email.max' => 'Il campo email non può superare i :max caratteri',

                'message.required' => 'Il campo messaggio è obbligatorio',
                'message.min' => 'Il campo messaggio deve contenere almeno :min caratteri',
            ]
        );

        if($validator->fails()){
            $success = false;
            $errors = $validator->errors();
            return response()->json(compact('success', 'errors'));
        }

        $success = true;

        $apartment = Apartment::where('slug', $slug)->where('is_visible', true)->first();

        $new_message = new Message;
        $new_message->fill($data);
        $new_message->apartment_id = $apartment->id;
        $new_message->save();


        return response()->json(compact('success'));
    }
}
