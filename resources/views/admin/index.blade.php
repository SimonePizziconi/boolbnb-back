@extends('layouts.app')

@section('content')
    Benvenuto, {{ $userName }}

    Ci sono {{ $apartmentCount }} <a href="{{ route('admin.apartments.index') }}">appartamenti</a> nel tuo DB
@endsection


@section('title')
    Dashboard
@endsection
