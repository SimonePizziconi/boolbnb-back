<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $apartmentCount = Apartment::where('user_id', Auth::user()->id)->count();

        // Recupera gli appartamenti con le statistiche
        $apartments = Apartment::where('user_id', Auth::user()->id)->with('statistics')->get();

        // Organizza i dati per visualizzazioni mensili per ciascun appartamento
        $data = $apartments->map(function ($apartment) {
            $monthlyViews = $apartment->statistics->groupBy(function ($statistic) {
                // Raggruppa per anno e mese
                return Carbon::parse($statistic->created_at)->format('Y-m');
            })->map(function ($statsPerMonth) {
                // Conta le visualizzazioni per ogni mese
                return $statsPerMonth->count();
            });

            return [
                'title' => $apartment->title,
                'monthly_views' => $monthlyViews
            ];
        });

        $userName = Auth::user()->first_name;

        return view('admin.index', compact('apartmentCount', 'userName', 'data'));
    }
}
