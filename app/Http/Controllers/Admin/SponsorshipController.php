<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Braintree\Gateway;

class SponsorshipController extends Controller
{

    public function showPaymentForm()
    {
        // Configuriamo la connessione con Braintree
        $gateway = new Gateway([
            'environment' => config('services.braintree.env'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key')
        ]);

        $apartments = Apartment::where('user_id', Auth::user()->id)->where('is_visible', true)->orderBy('id', 'desc')->get();
        $sponsorships = Sponsorship::all();

        // Otteniamo il client token per il front-end (necessario per il form)
        $clientToken = $gateway->clientToken()->generate();

        // Passiamo il client token al form di pagamento
        return view('admin.sponsorships.payment', compact('apartments', 'sponsorships', 'clientToken'));
    }


    public function processPayment(Request $request)
    {
        // Valida i dati in ingresso
        $validated = $request->validate([
            'package' => 'required|in:24,72,144',
            'apartment_id' => 'required|exists:apartments,id', // Valida che l'appartamento esista
        ]);

        // Ottieni l'ID dell'appartamento dal form
        $apartment = Apartment::findOrFail($request->input('apartment_id'));

        // Ottieni la durata del pacchetto selezionato
        $duration = $request->input('package');

        // Trova la sponsorizzazione in base alla durata
        $sponsorship = Sponsorship::where('duration', $duration)->first();

        if (!$sponsorship) {
            return redirect()->back()->with('error', 'Pacchetto sponsorizzazione non valido.');
        }

        // Verifica se c'è già una sponsorizzazione attiva
        $currentSponsorship = $apartment->sponsorships()
            ->wherePivot('end_date', '>', Carbon::now())
            ->first();

        if ($currentSponsorship) {
            // Estendi la sponsorizzazione esistente
            $newEndDate = Carbon::parse($currentSponsorship->pivot->end_date)->addHours($duration);

            // Aggiorna la data di fine nel record pivot
            $apartment->sponsorships()->updateExistingPivot($currentSponsorship->id, [
                'end_date' => $newEndDate,
            ]);

            return redirect()->route('admin.apartments.show', $apartment)
                ->with('success', 'La sponsorizzazione è stata estesa con successo di ' . $duration . ' ore.');
        }

        // Altrimenti, inizia una nuova sponsorizzazione
        $start_date = Carbon::now();
        $end_date = $start_date->copy()->addHours($duration);

        $apartment->sponsorships()->attach($sponsorship->id, [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        return redirect()->route('admin.apartments.show', $apartment)
            ->with('success', 'Sponsorizzazione attivata con successo per ' . $duration . ' ore.');
    }
}
