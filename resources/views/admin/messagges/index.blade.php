@extends('layouts.app')

@section('content')

@section('content')
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

    <div class="container">

        <h1 class="mb-5">Lista Messaggi</h1>

        <table class="table text-center">
            <thead>
                <tr>
                    <th scope="col" class="d-none d-md-table-cell">Appartamento</th>
                    <th scope="col" class="d-none d-md-table-cell">Nome utente</th>
                    <th scope="col">Email</th>
                    <th scope="col">Messaggio</th>
                    <th scope="col">Ora</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)

                    @foreach ( $apartment->messages as $message )

                        <tr>
                            <td class="d-none d-md-table-cell">
                                <div class="mb-2"><strong>{{$apartment->title}}</strong></div>
                                <div class="ratio ratio-1x1 pic">
                                    <a href="{{ route('admin.apartments.show', ['apartment' => $apartment->id]) }}">
                                        <img src="{{ asset('storage/' . $apartment->image_path) }}"
                                            alt="{{ $apartment->image_original_name }}" class="img-fluid object-fit-cover"
                                            onerror="this.src='/img/house-placeholder.jpg'">
                                    </a>
                                </div>
                            </td>

                            <td>
                                {{ $message->first_name }} {{ $message->last_name}}
                            </td>
                            <td>{{$message->email}}</td>
                            <td>{{$message->message}}</td>
                            <td>{{($message->created_at)->format('H:m')}}</td>
                            <td>{{($message->created_at)->format('d/m/Y')}}</td>
                        </tr>

                    @endforeach

                @endforeach
            </tbody>
        </table>

    </div>

@endsection

@section('title')
    Messaggi
@endsection
