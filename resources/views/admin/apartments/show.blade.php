@extends('layouts.app')


@section('content')

    <div class="container">
        <h1>{{ $apartment->title }}</h1>

        <div class="d-flex justify-content-around align-items-center flex-wrap my-5">
            <div class="col-md-5 col-12">
                <img src="{{ asset('storage/' . $apartment->image_path) }}" class="img-fluid rounded shadow" alt="{{ $apartment->image_original_name }}" onerror="this.src='/img/house-placeholder.jpg'">
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
                        <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-warning">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        ||
                        <strong>Elimina:</strong>
                        <form class="d-inline" id="form-delete-{{ $apartment->id }}"
                            action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                            onsubmit="return confirm('Sei sicuro di voler eliminare {{ $apartment->title }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
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
            <div class="col-md-5 col-12">
                <!-- Qui la mappa per il singolo appartamento -->
                <div id="map" style="width: 100%; aspect-ratio: 5/3;" class="img-fluid rounded shadow"></div>
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
@endsection


@section('title')
    Details - {{ $apartment->title }}
@endsection
