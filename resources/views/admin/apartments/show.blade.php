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
    </div>

    <div class="container">
        <h1>{{ $apartment->title }}</h1>

        <div class="d-flex justify-content-around align-items-center flex-wrap my-5">
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

        <div class="d-flex justify-content-around align-items-center flex-wrap my-5">
            <div class="col-md-4 col-12">
                @if (!$apartment->services->isEmpty())
                    <h3 class="mt-5 text-center">Servizi</h3>
                    <ul class="mt-3">
                        @foreach ($apartment->services as $service)
                            <li>{{ $service->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
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
    Details - {{ $apartment->title }}
@endsection
