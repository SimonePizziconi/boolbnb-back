@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container text-center" style="margin-top: 100px;">
            <h1>500 - Errore del server</h1>
            <p>Si è verificato un errore interno del server. Riprova più tardi.</p>
            <a href="{{ route('admin.index') }}" class="btn custom-delete">Torna alla home</a>
        </div>
    </div>
@endsection
