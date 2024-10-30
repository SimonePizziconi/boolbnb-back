<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Message;


class DashboardController extends Controller
{
    public function index()
    {
        $apartmentCount = Apartment::where('user_id', Auth::user()->id)->count();
        $publicApartmentsCount = Apartment::where('user_id', Auth::user()->id)->where('is_visible', 1)->count();
        $privateApartmentsCount = Apartment::where('user_id', Auth::user()->id)->where('is_visible', 0)->count();

        // Recupera gli appartamenti con le statistiche
        $apartments = Apartment::where('user_id', Auth::user()->id)->where('is_visible', 1)->with('statistics')->get();

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
                'apartment_id' => $apartment->id,
                'title' => $apartment->title,
                'monthly_views' => $monthlyViews
            ];
        });

        $userName = Auth::user()->first_name;

        return view('admin.index', compact('apartmentCount', 'userName', 'data', 'apartments', 'publicApartmentsCount', 'privateApartmentsCount'));
    }
}
