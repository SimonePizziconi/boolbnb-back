@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Accedi') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4 row">
                                <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo E-Mail') }}*</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                    <div class="input-group">
                                        <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                        <div class="input-group-append">
                                            <button id="togglePassword" type="button" class="btn btn-outline-secondary">
                                                <i class="far fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <span class="error-message text-danger" id="password_error"></span>

                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Ricordami') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Accedi') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Recupera La Tua Password?') }}
                                        </a>
                                    @endif
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

            form.addEventListener("submit", function (event) {
                let valid = true;

                // Reset degli errori
                const errorMessages = document.querySelectorAll(".error-message");
                errorMessages.forEach(message => {
                    message.innerHTML = "";
                });

                // Controllo per Email
                const email = document.getElementById("email");
                const emailPattern = /^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/; // Regex per email
                if (email.value.trim() === "") {
                    valid = false;
                    document.getElementById("email_error").innerHTML = "L'email è obbligatoria.";
                    email.classList.add('is-invalid'); // Aggiungi la classe is-invalid
                } else if (!emailPattern.test(email.value.trim())) {
                    valid = false;
                    document.getElementById("email_error").innerHTML = "Inserisci una mail valida";
                    email.classList.add('is-invalid'); // Aggiungi la classe is-invalid
                } else if (email.value.length > 255) {
                    valid = false;
                    document.getElementById("email_error").innerHTML = "L'email non può superare i 255 caratteri.";
                    email.classList.add('is-invalid'); // Aggiungi la classe is-invalid
                } else {
                    email.classList.remove('is-invalid'); // Rimuovi la classe is-invalid se non ci sono errori
                }

                // Controllo per Password
                const password = document.getElementById("password");
                if (password.value.trim() === "") {
                    valid = false;
                    document.getElementById("password_error").innerHTML = "La password è obbligatoria.";
                    password.classList.add('is-invalid'); // Aggiungi la classe is-invalid
                } else if (password.value.length < 8) {
                    valid = false;
                    document.getElementById("password_error").innerHTML = "La password deve contenere almeno 8 caratteri.";
                    password.classList.add('is-invalid'); // Aggiungi la classe is-invalid
                } else {
                    password.classList.remove('is-invalid'); // Rimuovi la classe is-invalid se non ci sono errori
                }

                // Se uno dei controlli fallisce, impedisci l'invio del modulo
                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>

@endsection
