<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessaggesController extends Controller
{
    public function showMessagges(){

        return view('admin.messagges.index');
    }
}
