@extends('layouts.app')


@section('content')
    <div class="wrapper p-5">

        <div class="label top">
            <h2>Modifica Appartamento</h2>
        </div>

        <div>

            <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @method('PUT')


                {{-- titolo --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Titolo</label>
                    <input type="text" required class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $apartment->title) }}">
                    @error('title')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                {{-- numero di camere --}}
                <div class="mb-3">
                    <label for="rooms" class="form-label">Numero di camere</label>
                    <input type="number" required class="form-control @error('rooms') is-invalid @enderror" id="rooms"
                        name="rooms" value="{{ old('rooms', $apartment->rooms) }}">
                    @error('rooms')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                {{-- numero di letti --}}
                <div class="mb-3">
                    <label for="beds" class="form-label">Numero di letti</label>
                    <input type="number" required class="form-control @error('beds') is-invalid @enderror" id="beds"
                        name="beds" value="{{ old('beds', $apartment->beds) }}">
                    @error('beds')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                {{-- numero di bagni --}}
                <div class="mb-3">
                    <label for="bathrooms" class="form-label">Numero di bagni</label>
                    <input type="number" required class="form-control @error('bathrooms') is-invalid @enderror"
                        id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $apartment->bathrooms) }}">
                    @error('bathrooms', $apartment->bathrooms)
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                {{-- metri quadrati --}}
                <div class="mb-3">
                    <label for="square_meters" class="form-label">Metri quadrati</label>
                    <input type="number" required class="form-control @error('square_meters') is-invalid @enderror"
                        id="square_meters" name="square_meters"
                        value="{{ old('square_meters', $apartment->square_meters) }}">
                    @error('square_meters')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>


                <div class="mb-3 row">

                    {{-- indirizzo --}}
                    <div class="col-6">
                        <label for="address" class="form-label">Via</label>
                        <input type="text" required class="form-control @error('address') is-invalid @enderror"
                            id="address" name="address" value="{{ old('address', $apartment->address) }}">
                        @error('address')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- città --}}
                    <div class="col">
                        <label for="city" class="form-label">Città</label>
                        <input type="text" required class="form-control @error('city') is-invalid @enderror" id="city"
                            name="city" value="{{ old('city', $apartment->city) }}">
                        @error('city')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- cap --}}
                    <div class="col">
                        <label for="cap" class="form-label">Cap</label>
                        <input type="text" required class="form-control @error('cap') is-invalid @enderror" id="cap"
                            name="cap" value="{{ old('cap', $apartment->cap) }}">
                        @error('cap')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
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
                    <img src="{{ asset('storage/' . $apartment->image_path) }}" id="thumb"
                        alt="{{ $apartment->image_original_name }}" onerror="this.src='/img/house-placeholder.jpg'">
                </div>

                {{-- impostazione visibilità --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" id="is_visible1" value="1"
                            {{ old('is_visible', $apartment->is_visible) == 1 ? 'checked' : '' }}>
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

                </div>

                {{-- bottone invio --}}
                <button type="submit" class="btn btn-primary">Invia</button>

            </form>

        </div>

    </div>

    <script>
        function showImage(event) {
            const thumb = document.getElementById('thumb');
            thumb.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection


@section('title')
    Edit Apartment
@endsection
