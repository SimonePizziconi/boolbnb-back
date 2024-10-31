@extends('layouts.app')


@section('content')
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        @if (session('success'))
            <div id="deletedToast" class="toast show bg-toast" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true" data-bs-delay="5000">
                <div class="toast-header">
                    <strong class="me-auto">Notifica</strong>
                    <small class="text-muted">Ora</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div id="deletedToast" class="toast show bg-toast" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true" data-bs-delay="5000">
                <div class="toast-header">
                    <strong class="me-auto">Notifica</strong>
                    <small class="text-muted">Ora</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        @endif
    </div>

    <div class="container">
        <h1>{{ $apartment->title }}</h1>
        <span>Sponsorizzazione:</span>
        @forelse ($apartment->sponsorships as $sponsorship)
            <span class="badge text-bg-success custom-delete">
                @if ($sponsorship->pivot->end_date)
                    <small class="badge custom-delete">Scadenza:
                        {{ \Carbon\Carbon::parse($sponsorship->pivot->end_date)->format('d/m/Y') }}</small>
                @endif
            </span>
        @empty
            Questo apppartamento non è ancora sponsorizzato
        @endforelse

        <div class="d-flex justify-content-around align-items-center flex-wrap my-5 border-bottom border-secondary pb-5">
            <div class="col-md-5 col-12">
                <img src="{{ asset('storage/' . $apartment->image_path) }}" class="img-fluid rounded shadow"
                    alt="{{ $apartment->image_original_name }}" onerror="this.src='/img/house-placeholder.jpg'">
            </div>

            <div class="col-md-4 col-12 text-center">
                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item"><strong>Indirizzo:</strong> {{ $apartment->address }}</li>
                    <li class="list-group-item"><strong>Stanze:</strong> {{ $apartment->rooms }}</li>
                    <li class="list-group-item"><strong>Bagni:</strong> {{ $apartment->bathrooms }}</li>
                    <li class="list-group-item"><strong>Posti letto:</strong> {{ $apartment->beds }}</li>
                    <li class="list-group-item"><strong>Metri quadri:</strong> {{ $apartment->square_meters }}mq</li>
                    <li class="list-group-item">
                        <strong>Modifica:</strong>
                        <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn custom-edit"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Modifica">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        ||
                        <strong>Elimina:</strong>
                        <a href="#deleteModal{{ $apartment->id }}" class="btn custom-delete" data-bs-toggle="modal"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Elimina">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                        <div class="modal fade" id="deleteModal{{ $apartment->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Conferma Eliminazione</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Sei sicuro di voler eliminare <span
                                            id="apartmentTitle">{{ $apartment->title }}</span>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn custom-edit"
                                            data-bs-dismiss="modal">Annulla</button>
                                        <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn custom-delete">Elimina</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="d-flex justify-content-around align-items-start flex-wrap my-5 border-bottom border-secondary pb-5">
            <div class="col-md-6 col-12">
                @if (!$apartment->services->isEmpty())
                    <h3 class="mt-5 text-center">Servizi</h3>
                    <ul class="mt-3">
                        @foreach ($apartment->services as $service)
                            <li>{{ $service->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-md-6 col-12">
                <h3 class="mt-5 me-2 text-center">Messaggi - <span class="number">{{ $messagesNumber }}</span></h3>


                @if (!empty($messages))
                    <ul class="messages-list-show text-xl-center">
                        @foreach ($messages as $message)
                            <li class="border-seconday border-bottom border-top pt-3 pb-3">
                                <span class="d-none d-md-inline"><strong>Ora: </strong>
                                    {{ $message->created_at->format('H:m') }}</span>
                                <span class="pe-5 mt-md-2 mb-md-2 pe-md-5 d-md-inline-block ps-md-0 pe-md-5"><strong>Data:
                                    </strong>{{ $message->created_at->format('d/m/Y') }}</span>
                                <span>
                                    <a href="#readModal{{ $message->id }}" data-bs-toggle="modal"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Leggi"
                                        class="btn custom-show close" {{-- {{route('admin.messages.open', $message)}} --}}>
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>

                                    {{-- Modale messaggio --}}
                                    <div class="modal fade" id="readModal{{ $message->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">
                                                        {{ $message->apartment->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body text-start">

                                                    <div class="m-3 d-flex justify-content-between">

                                                        <span>Inviato da - <strong>{{ $message->first_name }}
                                                                {{ $message->last_name }}</strong></span>

                                                        <div class="message-date">
                                                            <span>{{ $message->created_at->format('d/m/Y') }} -</span>
                                                            <span>{{ $message->created_at->format('H:m') }}</span>
                                                        </div>

                                                    </div>

                                                    <div class="message-text">
                                                        <p class="ms-3 mb-0">{{ $message->message }}</p>
                                                    </div>

                                                    <div class="m-3 text-end">
                                                        <span><strong>{{ $message->email }}</strong> - Indirizzo
                                                            Email</span>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn custom-edit"
                                                        data-bs-dismiss="modal">Annulla</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <h4>Non hai ricevuto messaggi per questo appartamento </h4>
                @endif
            </div>
        </div>

        <div class="text-center my-4 px-lg-5">
            <canvas id="apartmentChart"></canvas>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const apartmentChartCanvas = document.getElementById('apartmentChart');

                    // Dati JSON per ogni appartamento
                    let apartmentData = @json($data);
                    console.log(apartmentData);

                    // Crea il grafico all'inizio con dati vuoti
                    let apartmentChart = new Chart(apartmentChartCanvas, {
                        type: 'line',
                        data: {
                            labels: Object.keys(apartmentData.monthly_views),
                            datasets: [{
                                label: 'Visualizzazioni Mensili',
                                data: Object.values(apartmentData.monthly_views),
                                borderColor: '#006D77',
                                backgroundColor: '#D9D9D9',
                                borderWidth: 2,
                                fill: true,
                                responsive: true
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mese'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Visualizzazioni'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // function updateChart(apartmentId) {
                    //     const selectedApartmentData = apartmentData.find(apartment => apartment.apartment_id == apartmentId);

                    //     if (selectedApartmentData) {
                    //         // Aggiorna i dati del grafico
                    //         apartmentChart.data.labels = Object.keys(selectedApartmentData.monthly_views);
                    //         apartmentChart.data.datasets[0].data = Object.values(selectedApartmentData.monthly_views);
                    //         apartmentChart.update();
                    //         console.log(selectedApartmentData.title);
                    //     }
                    // }

                    // // Evento di cambio select
                    // apartmentSelect.addEventListener('change', function () {
                    //     updateChart(this.value);
                    // });

                    // // Inizializza il grafico con il primo appartamento
                    // updateChart(apartmentSelect.value);
                });
            </script>
        </div>


    </div>


    <!-- Inclusione del CSS e JS di TomTom Maps -->
    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.16.0/maps/maps.css" />
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.16.0/maps/maps-web.min.js"></script>

    <script>
        // Inserisci la tua chiave API di TomTom
        var apiKey = 'd0Xq2xNT1UVJmJOO7pFoBBiHcFLGGy2Q';

        // Controlla se l'appartamento ha coordinate valide prima di creare la mappa
        @if ($apartment->latitude && $apartment->longitude)
            var map = tt.map({
                key: apiKey,
                container: 'map',
                center: [{{ $apartment->longitude }}, {{ $apartment->latitude }}],
                zoom: 15
            });

            var marker = new tt.Marker()
                .setLngLat([{{ $apartment->longitude }}, {{ $apartment->latitude }}])
                .addTo(map);

            console.log('Latitudine:', apartment.latitude, 'Longitudine:', apartment.longitude);
        @else
            console.log('Coordinate mancanti per questo appartamento.');
        @endif
    </script>
    <script>
        // Script per nascondere notifica toast dopo 5 secondi

        document.addEventListener('DOMContentLoaded', function() {
            var toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(function(toastElement) {
                var toast = new bootstrap.Toast(toastElement);
                toast.show(); // Mostra la Toast
            });
        });
    </script>
@endsection


@section('title')
    Dettaglio - {{ $apartment->title }}
@endsection
