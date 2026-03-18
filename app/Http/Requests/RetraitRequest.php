<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RetraitRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'destination' => ['required', 'string', 'max:255'],
            'montant'     => ['required', 'integer', 'min:1'],
            'motif'       => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'destination.required' => 'Veuillez choisir une destination.',
            'montant.required'     => 'Le montant est obligatoire.',
            'montant.integer'      => 'Le montant doit être un nombre entier.',
            'montant.min'          => 'Le montant doit être supérieur à 0.',
        ];
    }
}