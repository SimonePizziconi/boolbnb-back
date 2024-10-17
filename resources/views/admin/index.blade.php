@extends('layouts.app')

@section('content')
    Benvenuto, {{ $userName }}

    Ci sono {{ $apartmentCount }} <a href="{{ route('admin.apartments.index') }}">appartamenti</a> registrati.
@endsection


@section('title')
    Dashboard - BoolBnB Admin Panel
@endsection
