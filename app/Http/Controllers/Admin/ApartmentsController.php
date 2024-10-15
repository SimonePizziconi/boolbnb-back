<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApartmentRequest;
use App\Models\Apartment;
use App\Functions\Helper;

class ApartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::orderBy('id', 'desc')->get();


        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApartmentRequest $request)
    {
        // prendo tutti i dati validati
        $data = $request->all();

        // richiamo la funzione pre creare concatenare tutti i dati dell'inidizzo in una sola stringa
        $data['address'] = Helper::getFullAddress($data['address'], $data['city'], $data['cap']);

        // genero lo slug
        $data['slug'] = Helper::generateSlug($data['title'], Apartment::class);

        // elimino da data le voci città e cap che non servono più,
        // array_splice($data, 7, 2);

        $queryAddress = Helper::convertAddressForQuery($data['address']);

        $response = Helper::getApi($queryAddress);

        $data['latitude'] = json_decode($response)->results['0']->position->lat;
        $data['longitude'] = json_decode($response)->results['0']->position->lon;
        // dd($data);

        $new_apartment = Apartment::create($data);

        return redirect()->route('admin.apartments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $apartment = Apartment::find($id);

        return view('admin.apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApartmentRequest $request, string $id)
    {
        $data = $request->all();

        // richiamo la funzione pre creare concatenare tutti i dati dell'inidizzo in una sola stringa
        $data['address'] = Helper::getFullAddress($data['address'], $data['city'], $data['cap']);

        // genero lo slug
        $data['slug'] = Helper::generateSlug($data['title'], Apartment::class);

        // elimino da data le voci città e cap che non servono più,
        // array_splice($data, 7, 2);

        $queryAddress = Helper::convertAddressForQuery($data['address']);

        $response = Helper::getApi($queryAddress);

        $data['latitude'] = json_decode($response)->results['0']->position->lat;
        $data['longitude'] = json_decode($response)->results['0']->position->lon;

        $update_apartment = Apartment::find($id);

        $update_apartment->fill($data);

        $update_apartment->save();

        return redirect()->route('admin.apartments.show', $update_apartment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('admin.apartments.index')->with('deleted', '"'.$apartment->title . '" è stato spostato nel cestino');
    }

    public function trash(){
        $apartments = Apartment::onlyTrashed()->orderBy('id', 'desc')->get();

        return view('admin.apartments.trash', compact('apartments'));
    }

    public function restore($id){
        $apartment = Apartment::withTrashed()->find($id);
        $apartment->restore();

        return redirect()->route('admin.apartments.index')->with('restored', '"'.$apartment->title . '" è stato ripristinato correttamente');
    }

    public function delete($id){
        $apartment = Apartment::withTrashed()->find($id);

        // if ($apartment->img_path) {
        //     Storage::delete($apartment->img_path);
        // }

        $apartment->forceDelete();

        return redirect()->route('admin.apartments.index')->with('deleted', '"'.$apartment->title . '" è stato eliminato definitivamente');
    }

}
