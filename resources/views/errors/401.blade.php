@extends('layouts.app')

@section('content')
    <div class="container text-center" style="margin-top: 100px;">
        <h1>401 - Non autorizzato</h1>
        <p>Non sei autorizzato ad accedere a questa risorsa. Effettua il login per continuare.</p>
        <a href="{{ url('/login') }}" class="btn custom-delete">Vai al login</a>
    </div>
@endsection
