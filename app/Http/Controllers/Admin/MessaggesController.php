<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Apartment;
use Illuminate\Support\Facades\Auth;

class MessaggesController extends Controller
{
    public function showMessagges(){

        //$messagges = Message::orderBy('id', 'desc')->with('apartment')->where('user_id', Auth::user()->id)->get();

        $data = Apartment::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->with('messages')->get();

        $apartments = [];

        foreach($data as $apartment){
            if(count($apartment->messages) !== 0){
                $apartments[] = $apartment;
            }
        }

        //dd($apartments);
        return view('admin.messagges.index', compact('apartments'));
    }
}
