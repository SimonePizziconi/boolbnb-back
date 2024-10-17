<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\Storage;


class PageController extends Controller
{
    public function index(){
        $apartments = Apartment::orderBy('id', 'desc')->with('services')->get();

        if($apartments){
            $success = true;
            foreach($apartments as $apartment){
                if (!$apartment->image_path) {
                    $apartment->image_path = asset('img/placeholder.jpg');
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

    // public function show(){
    //     dd('SHOW');
    // }
}
