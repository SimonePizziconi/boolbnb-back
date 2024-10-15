@extends('layouts.app')


@section('content')
    <div class="card" style="width: 18rem;">
        <img src="{{ asset('img/' . $apartment->image_path) }}" class="card-img-top"
            alt="{{ $apartment->image_original_name }}">
        <div class="card-body">
            <h5 class="card-title">{{ $apartment->title }}</h5>
            <p class="card-text">Indirizzo: {{ $apartment->address }}</p>
            <p class="card-text">Stanze: {{ $apartment->rooms }}</p>
            <p class="card-text">Bagni: {{ $apartment->bathrooms }}</p>
            <p class="card-text">Posti letto: {{ $apartment->beds }}</p>
            <p class="card-text">Metri quadri: {{ $apartment->square_meters }}</p>
            <p class="card-text">Servizi: ...</p>
            <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-warning"><i
                    class="fa-solid fa-pencil"></i>
            </a>
            <form class="d-inline" action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                onsubmit="return confirm('Vuoi eliminare')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
            </form>
        </div>
    </div>
@endsection


@section('title')
    Details
@endsection
