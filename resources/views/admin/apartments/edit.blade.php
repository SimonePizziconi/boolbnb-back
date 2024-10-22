@extends('layouts.app')


@section('content')
    <div class="wrapper p-5">

        <div class="label top">
            <h2>Modifica Appartamento</h2>
        </div>

        <div class="m-3">
            <ul>
                <li>
                    <small>I campi contrassegnati da * sono obbligatori</small>
                </li>
                <li>
                    <small>Per rendere pubblico l'appartamento, carica un'immagine valida</small>
                </li>
            </ul>
        </div>

        <div>

            <form id="apartment-form" action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @method('PUT')


                {{-- titolo --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Titolo*</label>
                    <input type="text" required class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $apartment->title) }}">
                    @error('title')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                    <small class="error-message text-danger" id="title_error"></small>
                </div>

                <div class="row">

                     {{-- numero di camere --}}
                    <div class="col-lg-4 col-sm-12">
                        <label for="rooms" class="form-label">Numero di camere</label>
                        <input type="number" class="form-control @error('rooms') is-invalid @enderror" id="rooms"
                            name="rooms" value="{{ old('rooms', $apartment->rooms) }}">
                        @error('rooms')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <small class="error-message text-danger" id="rooms_error"></small>
                    </div>

                    {{-- numero di letti --}}
                    <div class="col-lg-4 col-sm-12">
                        <label for="beds" class="form-label">Numero di letti</label>
                        <input type="number" class="form-control @error('beds') is-invalid @enderror" id="beds"
                            name="beds" value="{{ old('beds', $apartment->beds) }}">
                        @error('beds')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <small class="error-message text-danger" id="beds_error"></small>
                    </div>

                    {{-- numero di bagni --}}
                    <div class="col-lg-4 col-sm-12">
                        <label for="bathrooms" class="form-label">Numero di bagni</label>
                        <input type="number" class="form-control @error('bathrooms') is-invalid @enderror"
                            id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $apartment->bathrooms) }}">
                        @error('bathrooms', $apartment->bathrooms)
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <small class="error-message text-danger" id="bathrooms_error"></small>
                    </div>

                </div>

                {{-- metri quadrati --}}
                <div class="mb-3">
                    <label for="square_meters" class="form-label">Metri quadrati</label>
                    <input type="number" class="form-control @error('square_meters') is-invalid @enderror"
                        id="square_meters" name="square_meters"
                        value="{{ old('square_meters', $apartment->square_meters) }}">
                    @error('square_meters')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                    <small class="error-message text-danger" id="square_meters_error"></small>
                </div>


                <div class="mb-3 row">
                    <div class="col-12 address-search">
                        <label for="address" class="form-label">Via*</label>
                        @error('address')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <small class="error-message text-danger" id="address_error"></small>
                    </div>
                </div>

                {{-- servizi --}}
                <div class="mb-3">

                    <label for="type" class="form-label d-block">Servizi</label>
                        @foreach ($services as $service)
                           <input
                             name="services[]"
                             type="checkbox"
                             class="btn-check"
                             id="check-{{ $service->id }}"
                             autocomplete="off"
                             value="{{ $service->id }}"
                             {{--
                             validazione
                             checked
                             --}}
                             @checked($apartment->services->contains($service))>
                            <label class="btn m-1 btn-custom" for="check-{{ $service->id }}">{{ $service->name }}</label>
                        @endforeach

                </div>

                {{-- immagine --}}
                <div class="mb-3">
                    <label for="image_path" class="form-label">Inserisci un'immagine</label>
                    <input class="form-control" type="file" id="image_path" name="image_path"
                        onchange="showImage(event)">
                    @error('image_path')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                    <small class="error-message text-danger" id="image_path_error"></small>
                    <img src="{{ asset('storage/' . $apartment->image_path) }}" id="thumb"
                        alt="{{ $apartment->image_original_name }}" onerror="this.src='/img/house-placeholder.jpg'">
                </div>

                {{-- impostazione visibilità --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" id="is_visible1" value="1"
                            {{ old('is_visible', $apartment->is_visible) == 1 ? 'checked' : '' }}
                            {{ !$apartment->image_path ? 'disabled' : '' }}>
                        <label class="form-check-label" for="is_visible1">
                            Pubblico
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" id="is_visible2" value="0"
                            {{ old('is_visible', $apartment->is_visible) == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_visible2">
                            Privato
                        </label>
                    </div>
                    <small class="error-message text-danger" id="is_visible_error"></small>
                </div>

                {{-- bottone invio --}}
                <button type="submit" class="btn custom-show">Salva</button>

            </form>

        </div>

    </div>

    <script>
        // Funzione che gestisce la visualizzazione dell'immagine e lo stato del pulsante Pubblico
        function showImage(event) {
            const thumb = document.getElementById('thumb');
            const isVisible1 = document.getElementById('is_visible1');

            // Se l'utente carica un file, mostriamo l'anteprima
            if (event.target.files.length > 0) {
                thumb.src = URL.createObjectURL(event.target.files[0]);
                isVisible1.disabled = false;  // Abilitiamo il bottone "Pubblico"
            } else {
                // Se non c'è immagine, mostriamo il placeholder
                thumb.src = '/img/house-placeholder.jpg';
                isVisible1.disabled = true;  // Disabilitiamo il bottone "Pubblico"
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const thumb = document.getElementById('thumb');
            const isVisible1 = document.getElementById('is_visible1');
            const imageInput = document.getElementById('image_path');

            // Verifica se un'immagine è già stata caricata nel database
            const imagePath = "{{ old('image_path', $apartment->image_path) }}"; // Otteniamo il percorso dell'immagine
            const isImagePresent = imagePath && imagePath !== 'null'; // Verifica se l'immagine è già presente

            if (isImagePresent) {
                // Se esiste già un'immagine, mostriamo quella
                thumb.src = "{{ asset('storage/' . $apartment->image_path) }}";
                isVisible1.disabled = false; // Abilitiamo il bottone "Pubblico"
            } else if (imageInput.files.length > 0) {
                // Se l'utente ha caricato un'immagine tramite file input, mostriamo quella
                thumb.src = URL.createObjectURL(imageInput.files[0]);
                isVisible1.disabled = false; // Abilitiamo il bottone "Pubblico"
            } else {
                // Se non c'è immagine né caricata né presente nel database, mostriamo il placeholder
                thumb.src = '/img/house-placeholder.jpg';
                isVisible1.disabled = true; // Disabilitiamo il bottone "Pubblico"
            }
        });

        // tomtom autocomplete
        var options = {
            searchOptions: {
            key: "d0Xq2xNT1UVJmJOO7pFoBBiHcFLGGy2Q",
            language: "it-IT",
            limit: 5,
            },
            autocompleteOptions: {
            key: "d0Xq2xNT1UVJmJOO7pFoBBiHcFLGGy2Q",
            language: "it-IT",
            },
        }
        var ttSearchBox = new tt.plugins.SearchBox(tt.services, options)
        var searchBoxHTML = ttSearchBox.getSearchBoxHTML()

        const address = document.querySelector('.address-search');
        address.append(searchBoxHTML)

        // Selezionare l'input per id
        var inputElement = document.querySelector('input.tt-search-box-input');

        // Impostare il valore dell'input
        inputElement.value = "{{ old('address', $apartment->address) }}";
        inputElement.id = "address";
        inputElement.name = "address";
        inputElement.required = true;

        const inputContainer = document.querySelector('.tt-search-box-input-container');
        inputContainer.style.border = 'var(--bs-border-width) solid var(--bs-border-color)';
        inputContainer.style.borderRadius = 'var(--bs-border-radius)';

        document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('apartment-form');

        form.addEventListener('submit', function (event) {
            event.preventDefault();  // Prevenire invio del form se ci sono errori
            let isValid = true;

            // Reset messaggi di errore
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

            // Titolo
            const title = document.getElementById('title');
            const titleError = document.getElementById('title_error');
            const titleRegex = /^[a-zA-Z\s]+$/;
            if (!title.value || title.value.length < 3 || !titleRegex.test(title.value)) {
                isValid = false;
                titleError.textContent = "Il titolo deve contenere almeno 3 caratteri e non può avere numeri o caratteri speciali.";
            }

            // Stanze
            const rooms = document.getElementById('rooms');
            const roomsError = document.getElementById('rooms_error');
            if (rooms.value && (!Number.isInteger(+rooms.value) || +rooms.value <= 0)) {
                isValid = false;
                roomsError.textContent = "Il numero di stanze deve essere un numero intero maggiore di 0.";
            }

            // Letti
            const beds = document.getElementById('beds');
            const bedsError = document.getElementById('beds_error');
            if (beds.value && (!Number.isInteger(+beds.value) || +beds.value <= 0)) {
                isValid = false;
                bedsError.textContent = "Il numero di letti deve essere un numero intero maggiore di 0.";
            }

            // Bagni
            const bathrooms = document.getElementById('bathrooms');
            const bathroomsError = document.getElementById('bathrooms_error');
            if (bathrooms.value && (!Number.isInteger(+bathrooms.value) || +bathrooms.value <= 0)) {
                isValid = false;
                bathroomsError.textContent = "Il numero di bagni deve essere un numero intero maggiore di 0.";
            }

            // Metri quadri
            const squareMeters = document.getElementById('square_meters');
            const squareMetersError = document.getElementById('square_meters_error');
            if (squareMeters.value && (!Number.isInteger(+squareMeters.value) || +squareMeters.value <= 0)) {
                isValid = false;
                squareMetersError.textContent = "I metri quadri devono essere un numero intero maggiore di 0.";
            }

            // Indirizzo
            const address = document.getElementById('address');
            const addressError = document.getElementById('address_error');
            if (!address.value || address.value.length < 5) {
                isValid = false;
                addressError.textContent = "L'indirizzo deve contenere almeno 5 caratteri.";
            }

            // Immagine
            const image = document.getElementById('image_path');
            const imageError = document.getElementById('image_path_error');

            if (image.files.length > 0) {
                const file = image.files[0];
                const validImageTypes = ['image/jpeg', 'image/png'];
                if (!validImageTypes.includes(file.type) || file.size > 5120 * 1024) {
                    isValid = false;
                    imageError.textContent = "L'immagine deve essere un file .jpg o .png e non può superare i 5MB.";
                }
            }

            // Visibilità
            const visible1 = document.getElementById('is_visible1');
            const visible2 = document.getElementById('is_visible2');
            const visibleError = document.getElementById('is_visible_error');
            if (!visible1.checked && !visible2.checked) {
                isValid = false;
                visibleError.textContent = "La visibilità è un campo obbligatorio.";
            }

            if (isValid) {
                form.submit();  // Se tutto è valido, invia il form
            }

        });
    });

    </script>
@endsection


@section('title')
    Edit Apartment
@endsection
