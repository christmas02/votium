<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampagneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'customer_id'    => 'required|exists:customers,customer_id',
            
            // Image de couverture
            'image_couverture' => $this->isMethod('post') 
                                ? 'required|image|mimes:jpeg,png,jpg|max:3072' 
                                : 'nullable|image|mimes:jpeg,png,jpg|max:3072',

            // Booleans
            'text_cover_isActive'  => 'boolean',
            'inscription_isActive' => 'boolean',

            // Dates d'inscription : Obligatoires seulement si inscription_isActive est coché
            'inscription_date_debut' => 'required_if:inscription_isActive,1|nullable|date',
            'inscription_date_fin'   => 'required_if:inscription_isActive,1|nullable|date|after_or_equal:inscription_date_debut',
            
            // Heures d'inscription
            'heure_debut_inscription' => 'required_if:inscription_isActive,1|nullable',
            'heure_fin_inscription'   => 'required_if:inscription_isActive,1|nullable',

            // Paramètres de campagne
            'identifiants_personnalises_isActive' => 'required|string', // ex: "oui" / "non" selon ton schema
            'afficher_montant_pourcentage'        => 'required|in:clair,pourcentage,les_deux', 
            'ordonner_candidats_votes_decroissants' => 'required|string',
            // 'quantite_vote'                       => 'nullable|integer|min:1',

            // Design (Validation de code couleur Hexadécimal)
            'color_primaire'   => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'color_secondaire' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],

            'condition_participation' => 'required|string',
            'is_active'               => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                 => 'Le nom de la campagne est obligatoire.',
            'image_couverture.required'     => 'Une image de couverture est nécessaire.',
            'inscription_date_debut.required_if' => 'La date de début est requise si les inscriptions sont activées.',
            'inscription_date_fin.after_or_equal' => 'La date de fin doit être après la date de début.',
            'color_primaire.regex'          => 'La couleur primaire doit être un code HEX valide (ex: #FFFFFF).',
            'quantite_vote.integer'         => 'La quantité doit être un nombre entier.',
            'customer_id.exists'            => 'Le client sélectionné est invalide.',
        ];
    }

    /**
     * Préparer les données avant validation (pour les checkbox)
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'text_cover_isActive' => $this->has('text_cover_isActive') ? 1 : 0,
            'inscription_isActive' => $this->has('inscription_isActive') ? 1 : 0,
            'is_active' => $this->has('is_active') ? 1 : 0,
        ]);
    }
}