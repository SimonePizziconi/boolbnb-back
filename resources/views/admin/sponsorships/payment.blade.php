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
                            <div class="sponsorship-card card my_border_hover mb-4 rounded-3 shadow-sm"
                                data-id="{{ $sponsorship->duration }}">
                                <div class="card-header py-3">
                                    <h4 class="my-0 fw-normal text-uppercase fw-bold my_txt_secondary">
                                        {{ $sponsorship->name }} </h4>
                                </div>
                                <div class="card-body">
                                    <h1 class="card-title pricing-card-title my_txt_primary"><small
                                            class="text-body-secondary fw-light">€ </small>{{ $sponsorship->current_price }}
                                    </h1>
                                    <ul class="list-unstyled mt-3 mb-4">
                                        <li class="lh-lg">DURATA</li>
                                        @if ($sponsorship->duration <= 72)
                                            <li class="lh-lg fs-3 my_txt_accent">
                                                {{ $sponsorship->duration }} ore
                                            </li>
                                        @else
                                            <li class="lh-lg fs-3 my_txt_accent">
                                                {{ $sponsorship->duration / 24 }} giorni
                                            </li>
                                        @endif
                                    </ul>
                                    <button type="button"
                                        class="custom-show-reverse w-100 btn btn-lg btn-outline-primary">Seleziona</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Input nascosto per la sponsorizzazione -->
            <input type="hidden" name="package" id="package" required>

            <!-- Div per il drop-in di Braintree -->
            <div class="form-group">
                <div id="dropin-container"></div>
            </div>

            <input type="hidden" id="nonce" name="payment_method_nonce">
            <button type="submit" class="btn custom-show">Procedi con il pagamento</button>
        </form>
    </div>

    <!-- Modale di avviso -->
    <div class="modal fade" id="selectionModal" tabindex="-1" role="dialog" aria-labelledby="selectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectionModalLabel">Selezione richiesta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Per favore, seleziona una sponsorizzazione prima di procedere con il pagamento.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn custom-edit" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.30.0/js/dropin.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sponsorshipCards = document.querySelectorAll('.sponsorship-card');
            const packageInput = document.getElementById('package');
            const form = document.querySelector('#payment-form');
            let isCardSelected = false;

            // Gestore di evento per la selezione della card
            sponsorshipCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Rimuove la selezione da tutte le card
                    sponsorshipCards.forEach(c => c.classList.remove('selected'));

                    // Aggiunge la selezione alla card cliccata
                    card.classList.add('selected');

                    // Imposta l'ID della sponsorizzazione selezionata nel campo nascosto
                    packageInput.value = card.getAttribute('data-id');
                    isCardSelected = true; // Imposta isCardSelected a true
                });
            });

            // Genera il form drop-in di Braintree
            var clientToken = "{{ $clientToken }}";
            braintree.dropin.create({
                authorization: clientToken,
                container: '#dropin-container',
                translations: {
                    'payWithCard': 'Paga con carta'
                },
                locale: 'it_IT'
            }, function(createErr, instance) {
                if (createErr) {
                    console.error(createErr);
                    return;
                }

                // Gestore di evento per il submit del form
                form.addEventListener('submit', function(event) {
                    // Verifica se una card è stata selezionata
                    if (!isCardSelected) {
                        event.preventDefault(); // Impedisce l'invio del form

                        // Mostra il modale
                        var selectionModal = new bootstrap.Modal(document.getElementById(
                            'selectionModal'));
                        selectionModal.show();

                        return;
                    }

                    // Se una card è stata selezionata, continua con il pagamento
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
        });
    </script>
@endsection

@section('title')
    Sponsorizzazioni
@endsection
