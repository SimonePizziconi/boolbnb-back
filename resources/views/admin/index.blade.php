@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="my-3">Visualizzazioni per Appartamento</h1>

        Benvenuto, {{ $userName }}! Ci sono {{ $apartmentCount }} <a href="{{ route('admin.apartments.index') }}">appartamenti</a> registrati.


        <div class="container mt-5">
            <div class="row justify-content-between flex-wrap">
                @foreach($data as $index => $apartmentData)
                    <div class="col-6 my-4 px-5">
                        <h3>{{ $apartmentData['title'] }}</h3>
                        <canvas id="chart-{{ $index }}"></canvas>
                        <script>
                            const ctx{{ $index }} = document.getElementById('chart-{{ $index }}').getContext('2d');
                            new Chart(ctx{{ $index }}, {
                                type: 'line', // Tipo di grafico
                                data: {
                                    labels: {!! json_encode($apartmentData['monthly_views']->keys()) !!}, // Mesi
                                    datasets: [{
                                        label: 'Visualizzazioni Mensili',
                                        data: {!! json_encode($apartmentData['monthly_views']->values()) !!}, // Conteggio visualizzazioni per mese
                                        borderColor: '#006D77',
                                        backgroundColor: '#D9D9D9',
                                        borderWidth: 2,
                                        fill: true
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: { title: { display: true, text: 'Mese' } },
                                        y: { title: { display: true, text: 'Visualizzazioni' }, beginAtZero: true }
                                    }
                                }
                            });
                        </script>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection


@section('title')
    Dashboard - BoolBnB Admin Panel
@endsection
