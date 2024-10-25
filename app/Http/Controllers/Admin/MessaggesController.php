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

        $userId = Auth::id();
        $messages = Message::whereHas('apartment', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderBy('created_at', 'desc')->with('apartment')->get();

        foreach($messages as $message){
            $message->status = 'close';
        };

        $messagesNumber = count($messages);

        //dd($messages);
        return view('admin.messagges.index', compact('messages', 'messagesNumber'));
    }

    // public function openMessages(Request $request){

    //     dd($request->data);
    //     if($message->stauts = 'close'){
    //         $message->status = 'open';
    //     };


    //     return view('admin.messagges.index', compact('message'));
    // }
}
