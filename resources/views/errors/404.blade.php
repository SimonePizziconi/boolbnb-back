@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center" style="margin-top: 100px;">
            <h1>404 - Pagina non trovata</h1>
            <p>Siamo spiacenti, la pagina che stai cercando non è stata trovata.</p>
            <a href="{{ route('admin.index') }}" class="btn custom-delete">Torna alla home</a>
        </div>
    </div>
@endsection
