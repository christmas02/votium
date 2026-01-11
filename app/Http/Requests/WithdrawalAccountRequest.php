<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'     => 'required|exists:customers,customer_id',
            
            // Le nom du titulaire du compte
            'account_name'    => 'required|string|min:3|max:255',
            
            // Le numéro (MoMo, OM, ou RIB)
            'phone_number'    => 'required|string|min:8|max:20',
            
            // La méthode (OM, MOMO, WAVE, BANK, etc.)
            'payment_methode' => 'required|string',
            
            'is_active'       => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.exists'      => 'Le client est invalide.',
            'account_name.required'   => 'Le nom du compte est obligatoire.',
            'account_name.min'        => 'Le nom doit contenir au moins 3 caractères.',
            'phone_number.required'   => 'Le numéro de compte ou téléphone est requis.',
            'payment_methode.required' => 'Veuillez sélectionner une méthode de paiement.',
        ];
    }

    /**
     * Préparer les données avant validation
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? 1 : 0,
        ]);
    }
}