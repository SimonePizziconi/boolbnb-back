<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Message;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $messages =  [
            [
                'first_name' => 'Alice',
                'last_name' => 'Rossi',
                'email' => 'alice.rossi@example.com',
                'message' => 'Salve, vorrei sapere se l\'appartamento è disponibile per il prossimo mese. Grazie!'
            ],
            [
                'first_name' => 'Marco',
                'last_name' => 'Verdi',
                'email' => 'marco.verdi@example.com',
                'message' => 'Buongiorno, vorrei avere maggiori informazioni sulla posizione e i servizi disponibili nell\'appartamento.'
            ],
            [
                'first_name' => 'Giulia',
                'last_name' => 'Bianchi',
                'email' => 'giulia.bianchi@example.com',
                'message' => 'Salve, sono interessata a prenotare per un weekend. Quali sono le politiche di cancellazione?'
            ],
            [
                'first_name' => 'Luca',
                'last_name' => 'Neri',
                'email' => 'luca.neri@example.com',
                'message' => 'Buonasera, vorrei sapere se l\'appartamento accetta animali domestici. Grazie!'
            ],
            [
                'first_name' => 'Elena',
                'last_name' => 'Gialli',
                'email' => 'elena.gialli@example.com',
                'message' => 'Buongiorno, mi interessa sapere se l\'appartamento ha accesso a internet e TV.'
            ],
            [
                'first_name' => 'Davide',
                'last_name' => 'Blu',
                'email' => 'davide.blu@example.com',
                'message' => 'Ciao! Vorrei informazioni sulla disponibilità per 3 persone per la prossima settimana.'
            ],
            [
                'first_name' => 'Martina',
                'last_name' => 'Viola',
                'email' => 'martina.viola@example.com',
                'message' => 'Salve, potrebbe dirmi se ci sono restrizioni per bambini piccoli?'
            ],
            [
                'first_name' => 'Andrea',
                'last_name' => 'Marroni',
                'email' => 'andrea.marroni@example.com',
                'message' => 'Buongiorno, il parcheggio è disponibile per gli ospiti?'
            ],
            [
                'first_name' => 'Chiara',
                'last_name' => 'Argento',
                'email' => 'chiara.argento@example.com',
                'message' => 'Salve, vorrei sapere se l\'appartamento ha una vista panoramica.'
            ],
            [
                'first_name' => 'Giorgio',
                'last_name' => 'Verde',
                'email' => 'giorgio.verde@example.com',
                'message' => 'Buongiorno, potrei avere informazioni sulle modalità di pagamento?'
            ],
            [
                'first_name' => 'Sara',
                'last_name' => 'Bronzo',
                'email' => 'sara.bronzo@example.com',
                'message' => 'Salve, è possibile fare il check-in anticipato?'
            ],
            [
                'first_name' => 'Michele',
                'last_name' => 'Azzurri',
                'email' => 'michele.azzurri@example.com',
                'message' => 'Buonasera, quali sono le attività disponibili nelle vicinanze?'
            ],
        ];

        foreach($messages as $message){
            $apartment = Apartment::inRandomOrder()->first();

            $new_message = new Message();
            $new_message->apartment_id = $apartment->id;
            $new_message->first_name = $message['first_name'];
            $new_message->last_name = $message['last_name'];
            $new_message->email = $message['email'];
            $new_message->message = $message['message'];
            $new_message->save();
        }
    }
}
