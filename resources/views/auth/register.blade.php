@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registrati') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4 row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">Nome</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                        value="{{ old('first_name') }}" autocomplete="off" autofocus>

                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="error-message text-danger" id="first_name_error"></span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">Cognome</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                        value="{{ old('last_name') }}" autocomplete="off" autofocus>

                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="error-message text-danger" id="last_name_error"></span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="birth_date" class="col-md-4 col-form-label text-md-right">Data di
                                    Nascita</label>

                                <div class="col-md-6">
                                    <input id="birth_date" type="date"
                                        class="form-control @error('birth_date') is-invalid @enderror" name="birth_date"
                                        value="{{ old('birth_date') }}" autocomplete="off" autofocus>

                                    @error('birth_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="error-message text-danger" id="birth_date_error"></span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo E-Mail') }}*</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="off" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="error-message text-danger" id="email_error"></span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}*</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="off">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="error-message text-danger" id="password_error"></span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="off">
                                    <span class="error-message text-danger" id="password_confirmation_error"></span>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn custom-delete">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="m-4">
                    <small>I campi contrassegnati da * sono obbligatori</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");

            // Calcola la data massima per l'età di 18 anni
            const today = new Date();
            const minAge = 18;
            const maxDate = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate());

            // Formatta la data in "YYYY-MM-DD"
            const formattedMaxDate = maxDate.toISOString().split("T")[0];

            // Imposta il valore "max" nell'input per la data di nascita
            document.getElementById("birth_date").setAttribute("max", formattedMaxDate);


            form.addEventListener("submit", function (event) {
                let valid = true;

                // Reset degli errori
                const errorMessages = document.querySelectorAll(".error-message");
                errorMessages.forEach(message => {
                    message.innerHTML = "";
                });

                // Controllo per Nome
                const firstName = document.getElementById("first_name");
                if (firstName.value.trim() !== "") {
                    if (firstName.value.length < 3) {
                        valid = false;
                        document.getElementById("first_name_error").innerHTML = "Il nome deve contenere almeno 3 caratteri.";
                    } else if (firstName.value.length > 255) {
                        valid = false;
                        document.getElementById("first_name_error").innerHTML = "Il nome non può superare i 255 caratteri.";
                    } else if (!/^[a-zA-Z]+$/.test(firstName.value)) {
                        valid = false;
                        document.getElementById("first_name_error").innerHTML = "Il Nome non deve contenere numeri o caratteri speciali";
                    }
                }

                // Controllo per Cognome
                const lastName = document.getElementById("last_name");
                if (lastName.value.trim() !== "") {
                    if (lastName.value.length < 3) {
                        valid = false;
                        document.getElementById("last_name_error").innerHTML = "Il cognome deve contenere almeno 3 caratteri.";
                    } else if (lastName.value.length > 255) {
                        valid = false;
                        document.getElementById("last_name_error").innerHTML = "Il cognome non può superare i 255 caratteri.";
                    } else if (!/^[a-zA-Z]+$/.test(lastName.value)) {
                        valid = false;
                        document.getElementById("last_name_error").innerHTML = "Il Cognome non deve contenere numeri o caratteri speciali";
                    }
                }

                // Controllo per Data di Nascita
                const birthDate = document.getElementById("birth_date");
                if (birthDate.value.trim() !== "") {
                    const today = new Date();
                    const birth = new Date(birthDate.value);
                    const age = today.getFullYear() - birth.getFullYear();
                    const m = today.getMonth() - birth.getMonth();
                    if (age < 18 || (age === 18 && m < 0)) {
                        valid = false;
                        document.getElementById("birth_date_error").innerHTML = "Devi avere almeno 18 anni per registrarti.";
                    }
                }

                // Controllo per Email
                const email = document.getElementById("email");
                const emailPattern = /^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/; // Regex per email
                if (email.value.trim() === "") {
                    valid = false;
                    document.getElementById("email_error").innerHTML = "L'email è obbligatoria.";
                } else if (!emailPattern.test(email.value.trim())) {
                    valid = false;
                    document.getElementById("email_error").innerHTML = "Insserisci una mail valida";
                } else if (email.value.length > 255) {
                    valid = false;
                    document.getElementById("email_error").innerHTML = "L'email non può superare i 255 caratteri.";
                }

                // Controllo per Password
                const password = document.getElementById("password");
                const passwordConfirm = document.getElementById("password-confirm");
                if (password.value.trim() === "") {
                    valid = false;
                    document.getElementById("password_error").innerHTML = "La password è obbligatoria.";
                } else if (password.value.length < 8) {
                    valid = false;
                    document.getElementById("password_error").innerHTML = "La password deve contenere almeno 8 caratteri.";
                }
                if (password.value !== passwordConfirm.value) {
                    valid = false;
                    document.getElementById("password_confirmation_error").innerHTML = "Le password non corrispondono.";
                }

                // Se uno dei controlli fallisce, impedisci l'invio del modulo
                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>

@endsection
