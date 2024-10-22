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

        $apartments = Apartment::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->get();

        // Otteniamo il client token per il front-end (necessario per il form)
        $clientToken = $gateway->clientToken()->generate();

        // Passiamo il client token al form di pagamento
        return view('admin.sponsorships.payment', compact('apartments', 'clientToken'));
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

        // Ottieni la durata del pacchetto
        $duration = $request->input('package');

        // Trova la sponsorizzazione in base alla durata
        $sponsorship = Sponsorship::where('duration', $duration)->first();

        if (!$sponsorship) {
            return redirect()->back()->with('error', 'Pacchetto sponsorizzazione non valido.');
        }

        $currentSponsorship = $apartment->sponsorships()
            ->wherePivot('end_date', '>', Carbon::now())
            ->first();

        if ($currentSponsorship) {
            return redirect()->route('admin.apartments.show', $apartment)->with('error', 'Questo appartamento ha già una sponsorizzazione attiva.'); // Messaggio di errore
        }

        // Inizio sponsorizzazione
        $start_date = Carbon::now();

        // Fine sponsorizzazione
        $end_date = $start_date->copy()->addHours($duration);

        // Associa la sponsorizzazione all'appartamento
        $apartment->sponsorships()->attach($sponsorship->id, [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        // Redirect o visualizzazione di una pagina di successo
        return redirect()->route('admin.apartments.show', $apartment)
            ->with('success', 'Sponsorizzazione attivata con successo per ' . $duration . ' ore.');
    }
}
