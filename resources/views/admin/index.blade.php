@extends('layouts.app')

@section('content')

    <div class="container">
        Benvenuto, {{ $userName }}

        Ci sono {{ $apartmentCount }} <a href="{{ route('admin.apartments.index') }}">appartamenti</a> registrati.
    </div>

@endsection


@section('title')
    Dashboard - BoolBnB Admin Panel
@endsection
