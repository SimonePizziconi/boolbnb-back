@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-3">Visualizzazioni per Appartamento</h1>

        Benvenuto, {{ $userName }}! Ci sono {{ $apartmentCount }} <a
            href="{{ route('admin.apartments.index') }}">appartamenti</a> registrati.

        <!-- Seleziona l'appartamento -->
        <div class="form-group">
            <label for="apartment">Seleziona un appartamento:</label>
            <select name="apartment_id" id="apartment" class="form-control mt-2 mb-2" required>
                @foreach ($apartments as $apartment)
                    <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="container mt-5">
            <div class="col my-4 px-lg-5">
                <canvas id="apartmentChart"></canvas>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const apartmentSelect = document.getElementById('apartment');
                        const apartmentChartCanvas = document.getElementById('apartmentChart');

                        // Dati JSON per ogni appartamento
                        let apartmentData = @json($data);

                        // Crea il grafico all'inizio con dati vuoti
                        let apartmentChart = new Chart(apartmentChartCanvas, {
                            type: 'line',
                            data: {
                                labels: [],
                                datasets: [{
                                    label: 'Visualizzazioni Mensili',
                                    data: [],
                                    borderColor: '#006D77',
                                    backgroundColor: '#D9D9D9',
                                    borderWidth: 2,
                                    fill: true,
                                    responsive: true
                                }]
                            },
                            options: {
                                scales: {
                                    x: { title: { display: true, text: 'Mese' } },
                                    y: { title: { display: true, text: 'Visualizzazioni' }, beginAtZero: true }
                                }
                            }
                        });

                        function updateChart(apartmentId) {
                            const selectedApartmentData = apartmentData.find(apartment => apartment.apartment_id == apartmentId);

                            if (selectedApartmentData) {
                                // Aggiorna i dati del grafico
                                apartmentChart.data.labels = Object.keys(selectedApartmentData.monthly_views);
                                apartmentChart.data.datasets[0].data = Object.values(selectedApartmentData.monthly_views);
                                apartmentChart.update();
                                console.log(selectedApartmentData.title);
                            }
                        }

                        // Evento di cambio select
                        apartmentSelect.addEventListener('change', function () {
                            updateChart(this.value);
                        });

                        // Inizializza il grafico con il primo appartamento
                        updateChart(apartmentSelect.value);
                    });
                </script>
            </div>
        </div>
    </div>
@endsection


@section('title')
    Dashboard
@endsection
