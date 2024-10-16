<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $apartmentCount = Apartment::where('user_id', Auth::user()->id)->count();

        $userName = Auth::user()->first_name;

        return view('admin.index', compact('apartmentCount', 'userName'));
    }
}
