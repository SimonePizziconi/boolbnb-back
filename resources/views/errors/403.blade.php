@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container text-center" style="margin-top: 100px;">
            <h1>403 - Accesso negato</h1>
            <p>Non hai i permessi per accedere a questa pagina.</p>
            <a href="{{ route('admin.index') }}" class="btn custom-delete">Torna alla home</a>
        </div>
    </div>
@endsection
