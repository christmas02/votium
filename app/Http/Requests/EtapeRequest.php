<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtapeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'campagne_id'      => 'required|exists:campagnes,campagne_id',
            'name'             => 'required|string|max:255',
            'description'      => 'required|string|max:500',
            
            // Dates : La date de fin ne peut pas être avant la date de début
            'date_debut'       => 'required|date',
            'date_fin'         => 'required|date|after_or_equal:date_debut',
            
            // Heures
            'heure_debut'      => 'required',
            'heure_fin'        => 'required',

            'type_eligibility' => 'nullable|string|max:255',
            'seuil_selection'  => 'nullable|numeric|min:0',
            
            // Prix du vote : Même si stocké en string, on valide qu'il est numérique
            'prix_vote'        => 'required|numeric|min:0',
            
            'renitialisation'  => 'nullable|string',
            'package'          => 'nullable|string', // ex: Gratuit, Premium, etc.
            'is_active'        => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'campagne_id.exists'    => 'La campagne sélectionnée est invalide.',
            'name.required'         => 'Le nom de l’étape est obligatoire.',
            'date_fin.after_or_equal' => 'La date de fin doit être égale ou supérieure à la date de début.',
            'prix_vote.numeric'     => 'Le prix du vote doit être un montant valide.',
            'seuil_selection.numeric' => 'Le seuil doit être un nombre.',
            'package.required'      => 'Le type de package est obligatoire.',
        ];
    }

    /**
     * Nettoyage des données avant validation
     */
    protected function prepareForValidation()
    {
        $this->merge([
            // Si is_active n'est pas envoyé (checkbox non cochée), on met à 0 ou false
            'is_active' => $this->has('is_active') ? 1 : 0,
        ]);
    }
}