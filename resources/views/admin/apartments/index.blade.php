@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            @if (session('deleted'))
                <div id="deletedToast" class="toast show bg-toast" role="alert" aria-live="assertive" aria-atomic="true"
                    data-bs-autohide="true" data-bs-delay="5000">
                    <div class="toast-header">
                        <strong class="me-auto">Notifica</strong>
                        <small class="text-muted">Ora</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('deleted') }}
                    </div>
                </div>
            @endif
        </div>
        <div class="container-fluid">

            <div class="row">
                <h1 class="my-5">Lista Appartamenti</h1>
            </div>

            <div class="row justify-content-end">
                <div class="col-3 col-md-2 text-center me-3">
                    <div>
                        <a href="{{ route('admin.apartments.create') }}" class="btn custom-edit ms-sm-2 add-button"><i
                                class="fa-solid fa-plus"></i><span class="d-none d-xl-inline ps-2">Nuovo
                                Appartamento</span></a>
                    </div>

                </div>

            </div>

            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col" class="d-none d-md-table-cell">Id</th>
                        <th scope="col" class="d-none d-md-table-cell">Immagine</th>
                        <th scope="col">Titolo</th>
                        <th scope="col" class="d-none d-md-table-cell">Visibilità</th>
                        {{-- <th scope="col">Stanze</th>
                    <th scope="col">Camere</th>
                    <th scope="col">Bagni</th>
                    <th scope="col">Metri Quadri</th> --}}
                        {{-- <th scope="col" class="d-none d-md-table-cell">Indirizzo</th> --}}
                        <th scope="col" class="d-none d-lg-table-cell">Sponsorizzazione</th>
                        {{-- <th scope="col">Mappa</th> --}}
                        {{-- <th scope="col" class="d-none d-md-table-cell">Servizi</th> --}}
                        <th scope="col">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr>
                            <td class="d-none d-md-table-cell mytable-cell">{{ $apartment->id }}</td>
                            <td class="d-none d-md-table-cell">
                                <div class="ratio ratio-1x1">
                                    <img src="{{ asset('storage/' . $apartment->image_path) }}"
                                        alt="{{ $apartment->image_original_name }}" class="img-fluid object-fit-cover"
                                        onerror="this.src='/img/house-placeholder.jpg'">
                                </div>
                            </td>
                            <td class="mytable-cell">{{ $apartment->title }}</td>
                            <td class="d-none d-md-table-cell mytable-cell">
                                {{ $apartment->is_visible == 1 ? 'Pubblica' : 'Privata' }}
                            </td>
                            {{-- <td>{{ $apartment->rooms }}</td>
                        <td>{{ $apartment->beds }}</td>
                        <td>{{ $apartment->bathrooms }}</td>
                        <td>{{ $apartment->square_meters }}</td> --}}
                            {{-- <td class="d-none d-md-table-cell">{{ $apartment->address }}</td> --}}
                            {{-- <td>
                            <div id="map-{{ $apartment->id }}" style="width: 200px; height: 150px;"></div>
                        </td> --}}
                            <td class="d-none d-lg-table-cell mytable-cell">
                                @forelse ($apartment->sponsorships as $sponsorship)
                                    <div>
                                        @if ($sponsorship->pivot->end_date)
                                            <small class="badge custom-delete">Scadenza:
                                                {{ \Carbon\Carbon::parse($sponsorship->pivot->end_date)->format('d/m/Y') }}</small>
                                        @endif
                                    </div>
                                @empty
                                    -
                                @endforelse
                            </td>

                            {{-- <td class="d-none d-md-table-cell">
                            @forelse ($apartment->services as $service)
                                <span class="badge text-bg-success custom-delete">{{ $service->name }}</span>
                            @empty
                                -
                            @endforelse
                        </td> --}}
                            <td class="mytable-cell">
                                <div class="btn-resp d-inline-flex gap-1">
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Dettagli"
                                        class="btn custom-show"
                                        href="{{ route('admin.apartments.show', ['apartment' => $apartment->id]) }}">
                                        <i class="fa-solid fa-eye"></i></a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Modifica"
                                        class="btn custom-edit d-none d-lg-inline-block"
                                        href="{{ route('admin.apartments.edit', ['apartment' => $apartment->id]) }}">
                                        <i class="fa-solid fa-pen"></i></a>
                                    <a href="#deleteModal{{ $apartment->id }}" class="btn custom-delete"
                                        data-bs-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Elimina">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>

                                    {{-- Modale per eliminazione --}}
                                    <div class="modal fade" id="deleteModal{{ $apartment->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Conferma Eliminazione</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Sei sicuro di voler eliminare <span
                                                        id="apartmentTitle"><strong>{{ $apartment->title }}</strong></span>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn custom-edit"
                                                        data-bs-dismiss="modal">Annulla</button>
                                                    <form action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn custom-delete">Elimina</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $apartments->links() }}
        </div>

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

    <script>
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
    I tuoi Appartamenti
@endsection
