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

            <!-- Seleziona il pacchetto di sponsorizzazione -->
            <div class="form-group">
                <label for="package">Seleziona un pacchetto di sponsorizzazione:</label>
                <select name="package" id="package" class="form-control mt-2" required>
                    <option value="24">2.99 € per 24 ore</option>
                    <option value="72">5.99 € per 72 ore</option>
                    <option value="144">9.99 € per 144 ore</option>
                </select>
            </div>

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
