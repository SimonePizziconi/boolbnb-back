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
                <th scope="col">Latitudine</th>
                <th scope="col">Longitudine</th>
                <th scope="col">Servizi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apartments as $apartment)
                <tr>

                    <td>{{ $apartment->title }}</td>
                    <td class="w-25"><img src="{{ $apartment->image_path }}" alt="{{ $apartment->image_original_name }}"
                            class="w-50"></td>
                    <td>{{ $apartment->rooms }}</td>
                    <td>{{ $apartment->beds }}</td>
                    <td>{{ $apartment->bathrooms }}</td>
                    <td>{{ $apartment->square_meters }}</td>
                    <td>{{ $apartment->address }}</td>
                    <td>{{ $apartment->latitude }}</td>
                    <td>{{ $apartment->longitude }}</td>
                    <td>
                        <span class="badge text-bg-success">Servizi</span>
                    </td>
                    <td>
                        <a class="btn btn-success"
                            href="{{ route('admin.apartments.show', ['apartment' => $apartment->id]) }}"><i
                                class="fa-solid fa-eye"></i></a>
                        <a class="btn btn-warning"
                            href="{{ route('admin.apartments.edit', ['apartment' => $apartment->id]) }}"><i
                                class="fa-solid fa-pen"></i></a>
                        <form id="form-delete-{{$apartment->id}}" action="{{route('admin.apartments.destroy', $apartment)}}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare {{$apartment->title}}?')">
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
@endsection


@section('title')
    Apartments
@endsection
