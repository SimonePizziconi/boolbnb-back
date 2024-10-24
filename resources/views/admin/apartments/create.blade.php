@extends('layouts.app')


@section('content')
    <div class="wrapper p-5 container">

        <div class="label top">
            <h2>Nuovo Appartamento</h2>
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

            <form id="apartment-form" action="{{ route('admin.apartments.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                {{-- titolo --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Titolo*</label>
                    <input type="text" required class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title') }}" autocomplete="off">
                    @error('title')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                    <small class="error-message text-danger" id="title_error"></small>
                </div>


                <div class="row mb-3">

                    {{-- numero di camere --}}
                    <div class="col-lg-4 col-sm-12">

                        <label for="rooms" class="form-label">Numero di camere</label>
                        <input type="number" class="form-control @error('rooms') is-invalid @enderror" id="rooms"
                            name="rooms" value="{{ old('rooms') }}" autocomplete="off">
                        @error('rooms')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <small class="error-message text-danger" id="rooms_error"></small>

                    </div>

                    {{-- numero di letti --}}
                    <div class="col-lg-4 col-sm-12">

                        <label for="beds" class="form-label">Numero di letti</label>
                        <input type="number" class="form-control @error('beds') is-invalid @enderror" id="beds"
                            name="beds" value="{{ old('beds') }}" autocomplete="off">
                        @error('beds')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <small class="error-message text-danger" id="beds_error"></small>
                    </div>

                    {{-- numero di bagni --}}
                    <div class="col-lg-4 col-sm-12">

                        <label for="bathrooms" class="form-label">Numero di bagni</label>
                        <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" id="bathrooms"
                            name="bathrooms" value="{{ old('bathrooms') }}" autocomplete="off">
                        @error('bathrooms')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <small class="error-message text-danger" id="bathrooms_error"></small>
                    </div>

                </div>

                {{-- metri quadrati --}}
                <div class="mb-3">
                    <label for="square_meters" class="form-label">Metri quadrati</label>
                    <input type="number" class="form-control @error('square_meters') is-invalid @enderror"
                        id="square_meters" name="square_meters" value="{{ old('square_meters') }}" autocomplete="off">
                    @error('square_meters')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                    <small class="error-message text-danger" id="square_meters_error"></small>
                </div>

                <div class="mb-3 row">

                    {{-- indirizzo --}}
                    <div class="col-12 address-search">
                        <label for="address" class="form-label">Via*</label>
                        <input type="hidden" id="address_validated" name="address_validated" value="">

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
                        <input name="services[]" type="checkbox" class="btn-check" id="check-{{ $service->id }}"
                            autocomplete="off" value="{{ $service->id }}" {{-- validazione checked --}}
                            @checked(in_array($service->id, old('services', [])))>
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
                    <img src="/img/house-placeholder.jpg" alt="placeholder" id="thumb">
                </div>

                {{-- impostazione visibilità --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" id="is_visible1"
                            value="1" {{ old('is_visible') == 1 ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="is_visible1">
                            Pubblico
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" id="is_visible2"
                            value="0" {{ old('is_visible') == 0 ? 'checked' : '' }}>
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
        function showImage(event) {
            const thumb = document.getElementById('thumb');
            thumb.src = URL.createObjectURL(event.target.files[0]);

            const imageInput = document.getElementById('image_path');
            const isVisible1 = document.getElementById('is_visible1');

            if (imageInput.files.length > 0) {
                isVisible1.disabled = false;
            } else {
                isVisible1.disabled = true;
            }
        }

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

        var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
        var searchBoxHTML = ttSearchBox.getSearchBoxHTML();

        const addressContainer = document.querySelector('.address-search');
        addressContainer.append(searchBoxHTML);

        // Selezionare l'input per id
        var inputElement = document.querySelector('input.tt-search-box-input');
        var validatedField = document.getElementById('address_validated');

        // Impostare il valore dell'input usando old('address')
        document.addEventListener('DOMContentLoaded', function() {
            const oldAddress = "{{ old('address') }}";
            if (oldAddress) {
                inputElement.value = oldAddress;
                validatedField.value = oldAddress; // Mantieni il valore anche nel campo validato
            }
        });

        // Quando l'utente seleziona un indirizzo dai suggerimenti
        ttSearchBox.on('tomtom.searchbox.resultselected', function(data) {
            const selectedAddress = data.data.result.address.freeformAddress;
            inputElement.value = selectedAddress; // Aggiorna l'input visivo
            validatedField.value = selectedAddress; // Indica che l'indirizzo è valido
        });

        // Controlla l'input per prevenire l'invio del form se l'indirizzo non è validato
        const form = document.getElementById('apartment-form');
        form.addEventListener('submit', function(event) {
            // Se l'input non è validato
            if (!validatedField.value) {
                event.preventDefault();
                alert("Seleziona un indirizzo valido dall'elenco suggerito.");
                return false;
            }
        });



        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('apartment-form');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenire invio del form se ci sono errori
                let isValid = true;

                // Reset messaggi di errore
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

                // Titolo
                const title = document.getElementById('title');
                const titleError = document.getElementById('title_error');
                const titleRegex = /^[a-zA-Z\s]+$/;
                if (!title.value || title.value.length < 3 || !titleRegex.test(title.value)) {
                    isValid = false;
                    titleError.textContent =
                        "Il titolo deve contenere almeno 3 caratteri e non può avere numeri o caratteri speciali.";
                }

                // Stanze
                const rooms = document.getElementById('rooms');
                const roomsError = document.getElementById('rooms_error');
                if (rooms.value && (!Number.isInteger(+rooms.value) || +rooms.value <= 0)) {
                    isValid = false;
                    roomsError.textContent =
                        "Il numero di stanze deve essere un numero intero maggiore di 0.";
                }

                // Letti
                const beds = document.getElementById('beds');
                const bedsError = document.getElementById('beds_error');
                if (beds.value && (!Number.isInteger(+beds.value) || +beds.value <= 0)) {
                    isValid = false;
                    bedsError.textContent =
                        "Il numero di letti deve essere un numero intero maggiore di 0.";
                }

                // Bagni
                const bathrooms = document.getElementById('bathrooms');
                const bathroomsError = document.getElementById('bathrooms_error');
                if (bathrooms.value && (!Number.isInteger(+bathrooms.value) || +bathrooms.value <= 0)) {
                    isValid = false;
                    bathroomsError.textContent =
                        "Il numero di bagni deve essere un numero intero maggiore di 0.";
                }

                // Metri quadri
                const squareMeters = document.getElementById('square_meters');
                const squareMetersError = document.getElementById('square_meters_error');
                if (squareMeters.value && (!Number.isInteger(+squareMeters.value) || +squareMeters.value <=
                        0)) {
                    isValid = false;
                    squareMetersError.textContent =
                        "I metri quadri devono essere un numero intero maggiore di 0.";
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
                        imageError.textContent =
                            "L'immagine deve essere un file .jpg o .png e non può superare i 5MB.";
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
                    form.submit(); // Se tutto è valido, invia il form
                }

            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Controlla se ci sono errori
            if (document.getElementById('form-errors')) {
                // Se ci sono errori, scrolla in alto
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    </script>
@endsection


@section('title')
    Create Apartment
@endsection
