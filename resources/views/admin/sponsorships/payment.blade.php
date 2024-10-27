@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Paga la Sponsorizzazione</h1>
        <form id="payment-form" action="{{ route('admin.sponsorships.process') }}" method="POST">
            @csrf

            <!-- Seleziona l'appartamento -->
            <div class="form-group">
                <label for="apartment">Seleziona un appartamento:</label>
                <select name="apartment_id" id="apartment" class="form-control mt-2 mb-2" required>
                    @foreach ($apartments as $apartment)
                        <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="container mt-4 px-lg-5">
                <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                    @foreach ($sponsorships as $sponsorship)
                        <div class="col">
                            <div class="sponsorship-card card my_border_hover mb-4 rounded-3 shadow-sm" data-id="{{ $sponsorship->duration }}">
                                <div class="card-header py-3">
                                    <h4 class="my-0 fw-normal text-uppercase fw-bold my_txt_secondary"> {{ $sponsorship->name }} </h4>
                                </div>
                                <div class="card-body">
                                    <h1 class="card-title pricing-card-title my_txt_primary"><small class="text-body-secondary fw-light">€ </small>{{ $sponsorship->current_price }}</h1>
                                    <ul class="list-unstyled mt-3 mb-4">
                                        <li class="lh-lg">DURATA</li>
                                        @if ($sponsorship->duration <= 72)
                                            <li class="lh-lg fs-3 my_txt_accent">
                                                {{ $sponsorship->duration }} ore
                                            </li>
                                        @else
                                            <li class="lh-lg fs-3 my_txt_accent">
                                                {{ ($sponsorship->duration) / 24 }} giorni
                                            </li>
                                        @endif
                                    </ul>
                                    <button type="button" class="custom-show-reverse w-100 btn btn-lg btn-outline-primary">Seleziona</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Input nascosto per la sponsorizzazione -->
            <input type="hidden" name="package" id="package" required>

            {{-- <!-- Seleziona il pacchetto di sponsorizzazione -->
            <div class="form-group">
                <label for="package">Seleziona un pacchetto di sponsorizzazione:</label>
                <select name="package" id="package" class="form-control mt-2" required>
                    <option value="24">2.99 € per 24 ore</option>
                    <option value="72">5.99 € per 72 ore</option>
                    <option value="144">9.99 € per 144 ore</option>
                </select>
            </div> --}}

            <!-- Div per il drop-in di Braintree -->
            <div class="form-group">
                <div id="dropin-container"></div>
            </div>

            <input type="hidden" id="nonce" name="payment_method_nonce">
            <button type="submit" class="btn custom-show">Procedi con il pagamento</button>
        </form>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.30.0/js/dropin.min.js"></script>
    <script src="https://js.braintreegateway.com/web/dropin/1.30.0/js/dropin.min.js"></script>
    <script>
        document.querySelectorAll('.sponsorship-card').forEach(card => {
            card.addEventListener('click', function () {
                // Rimuove la selezione da tutte le card
                document.querySelectorAll('.sponsorship-card').forEach(c => c.classList.remove('selected'));

                // Aggiunge la selezione alla card cliccata
                card.classList.add('selected');

                // Imposta l'ID della sponsorizzazione selezionata nel campo nascosto
                document.getElementById('package').value = card.getAttribute('data-id');
            });
        });

        var form = document.querySelector('#payment-form');
        var clientToken = "{{ $clientToken }}";

        braintree.dropin.create({
            authorization: clientToken,
            container: '#dropin-container',
            translations: {
                'payWithCard': 'Paga con carta' // Traduci qui
            },
            locale: 'it_IT' // Imposta la lingua italiana
        }, function(createErr, instance) {
            if (createErr) {
                console.error(createErr);
                return;
            }

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.error(err);
                        return;
                    }

                    // Imposta il nonce nel campo nascosto
                    document.querySelector('#nonce').value = payload.nonce;

                    // Procedi con il form
                    form.submit();
                });
            });
        });
    </script>
@endsection
