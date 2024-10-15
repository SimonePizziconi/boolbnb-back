<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('admin.apartments.index')->with('deleted', $apartment->title . '" è stato spostato nel cestino');
    }

    public function trash(){
        $apartment = Apartment::onlyTrashed()->orderBy('id', 'desc')->get();

        return view('admin.apartments.trash', compact('apartments'));
    }

    public function restore($id){
        $apartment = Apartment::withTrashed()->find($id);
        $apartment->restore();

        return redirect()->route('admin.apartments.index')->with('restored', $apartment->title . '" è stato ripristinato correttamente');
    }

    public function delete($id){
        $apartment = Apartment::withTrashed()->find($id);

        // if ($apartment->img_path) {
        //     Storage::delete($apartment->img_path);
        // }

        $apartment->forceDelete();

        return redirect()->route('admin.apartments.index')->with('deleted', $apartment->title . '" è stato eliminato definitivamente');
    }

}
