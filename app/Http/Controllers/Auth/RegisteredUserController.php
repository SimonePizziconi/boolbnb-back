<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse

    {
        // Calcola la data di 18 anni fa
        $date18YearsAgo = now()->subYears(18)->toDateString();

        $request->validate(
            [
                'first_name' => ['nullable','string','min:3', 'max:255', 'alpha'],
                'last_name' => ['nullable','string','min:3','max:255', 'alpha'],
                'birth_date' => ['nullable','date', 'before_or_equal:'.$date18YearsAgo],
                'email' => ['required', 'string', 'lowercase', 'email', 'regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'first_name.string' => 'Il Nome non deve contenere numeri o caratteri speciali',
                'first_name.alpha' => 'Il Nome non deve contenere numeri o caratteri speciali',
                'first_name.min' => 'Il nome deve contenere almeno :min caratteri.',
                'first_name.max' => 'Il nome non può superare i :max caratteri.',
                'last_name.string' => 'Il Cognome non deve contenere numeri o caratteri speciali',
                'last_name.alpha' => 'Il Cognome non deve contenere numeri o caratteri speciali',
                'last_name.min' => 'Il cognome deve contenere almeno :min caratteri.',
                'last_name.max' => 'Il cognome non può superare i :max caratteri.',
                'birth_date.date' => 'La data di nascita non è valida.',
                'birth_date.before_or_equal' => 'Devi avere almeno 18 anni per registrarti.',
                'email.required' => 'L\'email è obbligatoria.',
                'email.lowercase' => 'L\'email deve essere in minuscolo.',
                'email.email' => 'L\'email non è valida.',
                'email.regex' => 'Insserisci una mail valida',
                'email.max' => 'L\'email non può superare i :max caratteri.',
                'email.unique' => 'Questa email è già in uso.',
                'password.required' => 'La password è obbligatoria.',
                'password.confirmed' => 'Le password non corrispondono.',
            ]
        );

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
