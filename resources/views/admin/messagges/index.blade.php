@extends('layouts.app')

@section('content')

    <div class="container">

        <h1 class="mb-5 me-2 messages-title">Lista Messaggi -</h1>

        <span class="number">{{$messagesNumber}}</span>


        <table class="table text-center">
            <thead>
                <tr>
                    <th scope="col" class="d-none d-md-table-cell">Immagine</th>
                    <th scope="col" class="d-none d-md-table-cell">Appartamento</th>
                    <th scope="col" class="d-none d-md-table-cell">Nome utente</th>
                    <th scope="col">Ora</th>
                    <th scope="col">Data</th>
                    <th scope="col">Leggi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)

                    {{-- @foreach ( $apartment->messages as $message ) --}}

                        <tr>
                            <td class="d-none d-md-table-cell apartment-cell">
                                <div class="ratio ratio-1x1 pic">
                                    <a href="{{ route('admin.apartments.show', ['apartment' => $message->apartment->id]) }}">
                                        <img src="{{ asset('storage/' . $message->apartment->image_path) }}"
                                            alt="{{ $message->apartment->image_original_name }}" class="img-fluid object-fit-cover"
                                            onerror="this.src='/img/house-placeholder.jpg'">
                                    </a>
                                </div>
                            </td>

                            <td class="d-none d-md-table-cell apartment-cell message-cell">
                                <a href="{{ route('admin.apartments.show', ['apartment' => $message->apartment->id]) }}"><strong>{{$message->apartment->title}}</strong></a>
                            </td>

                            <td class="message-cell d-none d-md-table-cell">
                                {{ $message->first_name }} {{ $message->last_name}}
                            </td>
                            <td class="message-cell">{{($message->created_at)->format('H:m')}}</td>
                            <td class="message-cell">{{($message->created_at)->format('d/m/Y')}}</td>

                            <td class="message-cell">
                                <a href="#readModal{{ $message->id }}" data-bs-toggle="modal"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Leggi" class="btn custom-delete close" {{-- {{route('admin.messages.open', $message)}} --}} >

                                    @if($message->status === 'close')
                                        <i class="fa-solid fa-envelope"></i>

                                    @else
                                        <i class="fa-solid fa-envelope-open-text"></i>

                                    @endif
                                </a>


                                 {{-- Modale messaggio --}}
                                <div class="modal fade" id="readModal{{ $message->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">

                                    <div class="modal-dialog" role="document">

                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">{{$message->apartment->title}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body text-start">

                                                <div class="m-3 d-flex justify-content-between">

                                                    <span>Inviato da - <strong>{{$message->first_name}} {{$message->last_name}}</strong></span>

                                                    <div class="message-date">
                                                        <span>{{($message->created_at)->format('d/m/Y')}} -</span>
                                                        <span>{{($message->created_at)->format('H:m')}}</span>
                                                    </div>

                                                </div>

                                                <div class="message-text">
                                                    <p class="ms-3 mb-0">{{$message->message}}</p>
                                                </div>

                                                <div class="m-3 text-end">
                                                    <span><strong>{{$message->email}}</strong> - Indirizzo Email</span>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn custom-edit"
                                                    data-bs-dismiss="modal">Annulla</button>
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

    <script>

        const messagesButtons = document.getElementsByClassName("close");

        for(let i = 0; i < messagesButtons.length; i++){
            let button = messagesButtons[i];

            button.addEventListener("click",
                function(open){
                    open.preventDefault();

                    //console.log(messagesButtons[i]);

                    messagesButtons[i].classList.remove("custom-delete");
                    messagesButtons[i].classList.add("custom-show");
                    messagesButtons[i].innerHTML = '<i class="fa-solid fa-envelope-open-text"></i>';
                    messagesButtons[i].classList.add('open');


                }
            )
        }


    </script>

@endsection

@section('title')
    Messaggi
@endsection
