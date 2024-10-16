@extends('layouts.app')


@section('content')
    <div class="card" style="width: 18rem;">
        <img src="{{ asset('storage/' . $apartment->image_path) }}" class="card-img-top"
            alt="{{ $apartment->image_original_name }}" onerror="this.src='/img/house-placeholder.jpg'">
        <div class="card-body">
            <h5 class="card-title">{{ $apartment->title }}</h5>
            <p class="card-text">Indirizzo: {{ $apartment->address }}</p>
            <p class="card-text">Stanze: {{ $apartment->rooms }}</p>
            <p class="card-text">Bagni: {{ $apartment->bathrooms }}</p>
            <p class="card-text">Posti letto: {{ $apartment->beds }}</p>
            <p class="card-text">Metri quadri: {{ $apartment->square_meters }}</p>
            <p class="card-text">Servizi:
                @forelse ($apartment->services as $service)
                    <span class="badge text-bg-success">{{ $service->name }}</span>
                @empty
                    <span>Non è stato assegnato nessun servizio</span>
                @endforelse
            </p>
            <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn custom-edit" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Modifica"><i class="fa-solid fa-pencil"></i>
            </a>
            <form class="d-inline" id="form-delete-{{ $apartment->id }}"
                action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                onsubmit="return confirm('Sei sicuro di voler eliminare {{ $apartment->title }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn custom-delete" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Elimina">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Qui la mappa per il singolo appartamento -->
    <div id="map" style="width: 200px; height: 150px;"></div>
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
