<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        $apartmentCount = Apartment::count();

        $userName = Auth::user()->first_name;

        // dd($userName);

        return view('admin.index', compact('apartmentCount', 'userName'));
    }
}
