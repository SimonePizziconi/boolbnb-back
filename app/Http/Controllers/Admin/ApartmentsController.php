<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApartmentRequest;
use App\Models\Apartment;
use App\Models\Service;
use App\Functions\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ApartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->paginate(10);
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::orderBy('name')->get();
        return view('admin.apartments.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApartmentRequest $request)
    {
        // prendo tutti i dati validati
        $data = $request->all();

        //dd($data);
        // prendo user id
        $data['user_id'] = Auth::user()->id;

        // genero lo slug
        $data['slug'] = Helper::generateSlug($data['title'], Apartment::class);

        // richiamo la funzione pre creare concatenare tutti i dati dell'inidizzo in una sola stringa
        // $addressToEncode = Helper::getFullAddress($data['address']);

        // encode dato address
        $queryAddress = Helper::convertAddressForQuery($data['address']);

        // chiamata api per ricavare latitudine e longitudine
        $response = Helper::getApi($queryAddress);

        // salvo la latitudine in una variabile
        $data['latitude'] = json_decode($response)->results['0']->position->lat;
        // salvo la longitudine in una variabile
        $data['longitude'] = json_decode($response)->results['0']->position->lon;
        //dd($data);

        if (array_key_exists('image_path', $data)) {
            $image_path = Storage::put('uploads', $data['image_path']);

            $image_original_name = $request->file('image_path')->getClientOriginalName();

            $data['image_path'] = $image_path;
            $data['image_original_name'] = $image_original_name;
        }

        // creo un nuovo appartamento
        $new_apartment = Apartment::create($data);

        $new_apartment->services()->attach($data['services']);

        return redirect()->route('admin.apartments.show', $new_apartment)->with('success', '"' . $data['title'] .  '" è stato aggiunto correttamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::user()->id) {
            abort(404);
        }

        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $apartment = Apartment::find($id);
        $services = Service::orderBy('name')->get();

        if ($apartment->user_id !== Auth::user()->id) {
            abort(404);
        }

        return view('admin.apartments.edit', compact('apartment', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApartmentRequest $request, string $id)
    {

        $data = $request->all();

        $update_apartment = Apartment::find($id);

        if ($update_apartment->user_id !== Auth::user()->id) {
            abort(404);
        }

        // genero lo slug
        $data['slug'] = Helper::generateSlug($data['title'], Apartment::class);

        // $addressToEncode = Helper::getFullAddress($data['address'], $data['city'], $data['cap']);

        // encode dato address
        $queryAddress = Helper::convertAddressForQuery($data['address']);

        // chiamata api per ricavare latitudine e longitudine
        $response = Helper::getApi($queryAddress);

        $data['latitude'] = json_decode($response)->results['0']->position->lat;
        $data['longitude'] = json_decode($response)->results['0']->position->lon;

        if (array_key_exists('image_path', $data)) {
            $image_path = Storage::put('uploads', $data['image_path']);

            $image_original_name = $request->file('image_path')->getClientOriginalName();

            $data['image_path'] = $image_path;
            $data['image_original_name'] = $image_original_name;
        }

        $update_apartment->fill($data);
        $update_apartment->services()->sync($data['services']);

        $update_apartment->save();

        return redirect()->route('admin.apartments.show', $update_apartment)->with('success', '"' . $data['title'] .  '" è stato modificato correttamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('admin.apartments.index')->with('deleted', '"' . $apartment->title . '" è stato eliminato correttamente');
    }
}
