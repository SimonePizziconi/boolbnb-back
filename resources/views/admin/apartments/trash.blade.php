@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h1 class="my-5">Cestino</h1>
        @if (!$apartments->isEmpty())
            <ul class="list-group m-4">

                @foreach ($apartments as $apartment)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><strong>Id: </strong> {{ $apartment->id }} || <strong>Titolo:</strong> {{ $apartment->title }}
                        </span>
                        <div>
                            <form class="d-inline" action="{{ route('admin.apartments.restore', $apartment) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn custom-show" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Recupera">
                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                </button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.apartments.delete', $apartment) }}"
                                method="POST"
                                onsubmit="return confirm('Sei sicuro di voler eliminare definitivamente questo appartamento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn custom-delete" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Elimina definitivamente">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-success text-center">
                Il Cestino è vuoto!
            </div>
        @endif
    </div>
@endsection

@section('title')
    Trash Apartments List
@endsection
