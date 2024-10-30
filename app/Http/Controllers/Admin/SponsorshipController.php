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
            'apartment_id' => 'required|exists:apartments,id',
            'payment_method_nonce' => 'required' // Assicurati che il nonce sia presente
        ]);

        // Configurazione del gateway Braintree
        $gateway = new Gateway([
            'environment' => config('services.braintree.env'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key')
        ]);

        // Ottieni i dettagli della sponsorizzazione e dell'appartamento
        $apartment = Apartment::findOrFail($validated['apartment_id']);
        $duration = $validated['package'];
        $sponsorship = Sponsorship::where('duration', $duration)->first();

        if (!$sponsorship) {
            return redirect()->back()->with('error', 'Pacchetto sponsorizzazione non valido.');
        }

        // Creazione della transazione Braintree
        $result = $gateway->transaction()->sale([
            'amount' => $sponsorship->current_price,
            'paymentMethodNonce' => $validated['payment_method_nonce'],
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        // Verifica l’esito della transazione
        if ($result->success) {
            // Se il pagamento è andato a buon fine, procedi con l'attivazione della sponsorizzazione
            $currentSponsorship = $apartment->sponsorships()
                ->wherePivot('end_date', '>', Carbon::now())
                ->first();

            if ($currentSponsorship) {
                $newEndDate = Carbon::parse($currentSponsorship->pivot->end_date)->addHours($duration);
                $apartment->sponsorships()->updateExistingPivot($currentSponsorship->id, [
                    'end_date' => $newEndDate,
                ]);

                return redirect()->route('admin.apartments.show', $apartment)
                    ->with('success', 'La sponsorizzazione è stata estesa con successo di ' . $duration . ' ore.');
            }

            // Avvia una nuova sponsorizzazione se non ce n’è una attiva
            $start_date = Carbon::now();
            $end_date = $start_date->copy()->addHours($duration);

            $apartment->sponsorships()->attach($sponsorship->id, [
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);

            return redirect()->route('admin.apartments.show', $apartment)
                ->with('success', 'Sponsorizzazione attivata con successo per ' . $duration . ' ore.');
        } else {
            // Gestisci il caso di errore nella transazione
            return redirect()->back()->with('error', 'Transazione non riuscita: ' . $result->message);
        }
    }
}
