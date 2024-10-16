<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Functions\Helper;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $the_services = [
            'WiFi',
            'Posto Macchina',
            'Piscina',
            'Portineria',
            'Sauna',
            'Vista Mare',
            'Aria Condizionata',
            'Riscaldamento',
            'TV via Cavo',
            'Cucina Completa',
            'Lavastoviglie',
            'Lavatrice',
            'Asciugatrice',
            'Balcone',
            'Giardino Privato',
            'Barbecue',
            'Vasca Idromassaggio',
            'Camino',
            'Accesso Disabili',
            'Animali Ammessi',
            'Palestra',
            'Spa',
            'Servizio in Camera',
            'Colazione Inclusa',
            'Ristorante in Loco',
            'Navetta Aeroporto',
            'Parco Giochi',
            'Deposito Bagagli',
            'Parcheggio Bici',
            'Noleggio Auto',
            'Servizio di Pulizia',
            'Reception 24 Ore',
            'Cassaforte',
            'Frigorifero',
            'Mini Bar',
            'Servizio Lavanderia',
            'Cambio Biancheria',
            'Vista Montagna',
            'Vicino alla Spiaggia',
            'Accesso alla Pista Ciclabile'
        ];

        foreach($the_services as $service){
            $new_service = new Service;
            $new_service->name = $service;
            $new_service->slug = Helper::generateSlug($new_service->name, Service::class);
            $new_service->save();
        }
    }
}
