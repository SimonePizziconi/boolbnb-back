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

    <h1>Lista Messaggi</h1>

@endsection

@section('title')
    Messaggi
@endsection
