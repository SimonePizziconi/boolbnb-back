@extends('layouts.app')

@section('content')
    @if (session('deleted'))
        <div class="alert alert-success" role="alert">
            {{ session('deleted') }}
        </div>
    @endif

    @if (session('restored'))
        <div class="alert alert-success" role="alert">
            {{ session('restored') }}
        </div>
    @endif

    <h1>Lista Appartamenti</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Titolo</th>
                <th scope="col">Immagine</th>
                <th scope="col">Stanze</th>
                <th scope="col">Camere</th>
                <th scope="col">Bagni</th>
                <th scope="col">Metri Quadri</th>
                <th scope="col">Indirizzo</th>
                {{-- <th scope="col">Mappa</th> --}}
                <th scope="col">Servizi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apartments as $apartment)
                <tr>
                    <td>{{ $apartment->title }}</td>
                    <td class="w-25">
                        <img src="{{ asset('storage/' . $apartment->image_path) }}"
                            alt="{{ $apartment->image_original_name }}" class="w-50"
                            onerror="this.src='/img/house-placeholder.jpg'">
                    </td>
                    <td>{{ $apartment->rooms }}</td>
                    <td>{{ $apartment->beds }}</td>
                    <td>{{ $apartment->bathrooms }}</td>
                    <td>{{ $apartment->square_meters }}</td>
                    <td>{{ $apartment->address }}</td>
                    {{-- <td>
                        <div id="map-{{ $apartment->id }}" style="width: 200px; height: 150px;"></div>
                    </td> --}}
                    <td>
                        @forelse ($apartment->services as $service)
                            <span class="badge text-bg-success ">{{ $service->name }}</span>
                        @empty
                            -
                        @endforelse
                    </td>
                    <td>
                        <a class="btn btn-success"
                            href="{{ route('admin.apartments.show', ['apartment' => $apartment->id]) }}">
                            <i class="fa-solid fa-eye"></i></a>
                        <a class="btn btn-warning"
                            href="{{ route('admin.apartments.edit', ['apartment' => $apartment->id]) }}">
                            <i class="fa-solid fa-pen"></i></a>
                        <form id="form-delete-{{ $apartment->id }}"
                            action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                            onsubmit="return confirm('Sei sicuro di voler eliminare {{ $apartment->title }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $apartments->links() }}
    </div>

    <!-- Inclusione del CSS e JS di TomTom Maps -->
    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.16.0/maps/maps.css" />
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.16.0/maps/maps-web.min.js"></script>

    <script>
        // Inserisci la tua chiave API di TomTom
        var apiKey = 'd0Xq2xNT1UVJmJOO7pFoBBiHcFLGGy2Q';

        // Itera sugli appartamenti e genera una mappa per ciascuno
        var apartments = @json($apartments);

        apartments.data.forEach(function(apartment) {
            if (apartment.latitude && apartment.longitude) {
                var map = tt.map({
                    key: apiKey,
                    container: 'map-' + apartment.id,
                    center: [apartment.longitude, apartment.latitude],
                    zoom: 15
                });

                var marker = new tt.Marker()
                    .setLngLat([apartment.longitude, apartment.latitude])
                    .addTo(map);

                console.log('Latitudine:', apartment.latitude, 'Longitudine:', apartment.longitude);
            } else {
                console.log('Coordinate mancanti per l\'appartamento con ID: ' + apartment.id);
            }
        });
    </script>
@endsection

@section('title')
    Apartments List
@endsection
