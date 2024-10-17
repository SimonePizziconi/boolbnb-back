<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3|regex:/^[a-zA-Z\s]+$/',
            'rooms' => 'nullable|numeric|integer|gt:0',
            'beds' => 'nullable|numeric|integer|gt:0',
            'bathrooms' => 'nullable|numeric|integer|gt:0',
            'square_meters' => 'nullable|numeric|integer|gt:0',
            'address' => 'required|min:5',
            'image_path' => 'image|mimes:png,jpg|max:5120',
            'is_visible' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
       return [
            'title.required' => 'Il titolo è un campo obbligatorio',
            'title.min' => 'Il titolo deve contenere almeno :min caratteri',
            'title.regex' => 'Il titolo non può contenere numeri o caratteri speciali',

            'rooms.numeric' => 'Il numero di stanze deve essere un numero',
            'rooms.integer' => 'Il numero di stanze deve essere un numero',
            'rooms.gt' => 'Il numero di stanze deve essere almeno 1',

            'beds.numeric' => 'Il numero di stanze deve essere un numero',
            'beds.integer' => 'Il numero di stanze deve essere un numero',
            'beds.gt' => 'Il numero di stanze deve essere almeno 1',

            'bathrooms.numeric' => 'Il numero di stanze deve essere un numero',
            'bathrooms.integer' => 'Il numero di stanze deve essere un numero',
            'bathrooms.gt' => 'Il numero di stanze deve essere almeno 1',

            'square_meters.numeric' => 'Il numero di stanze deve essere un numero',
            'square_meters.integer' => 'Il numero di stanze deve essere un numero',
            'square_meters.gt' => 'Il numero di stanze deve essere almeno 1',

            'address.required' => 'Il titolo è un campo obbligatorio',
            'address.min' => 'Il titolo deve contenere almeno :min caratteri',

            'image_path.image' => 'Il file caricato deve essere un\'immagine',
            'image_path.mimes' => 'Il file caricato deve essere di tipo .jpg o .png',
            'image_path.max' => 'Il file caricato deve essere al massimo di 5Mb',

            'is_visible' => 'La visibilità è un campo obbligatorio',

        ];
    }
}
