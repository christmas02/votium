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
        // On vérifie si on a un ID de campagne (donc on est en update)
        // Soit via un champ caché,
        $isUpdate = $this->filled('campagne_id');

        return [
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'customer_id'    => 'required|exists:customers,customer_id',

            'image_couverture' => $isUpdate
                ? 'nullable|image|mimes:jpeg,png,jpg|max:3072'
                : 'required|image|mimes:jpeg,png,jpg|max:3072',

            'text_cover_isActive'  => 'boolean',
            'inscription_isActive' => 'boolean',

            'inscription_date_debut' => 'required_if:inscription_isActive,1|nullable|date',
            'inscription_date_fin'   => 'required_if:inscription_isActive,1|nullable|date|after_or_equal:inscription_date_debut',

            'heure_debut_inscription' => 'required_if:inscription_isActive,1|nullable',
            'heure_fin_inscription'   => 'required_if:inscription_isActive,1|nullable',

            'identifiants_personnalises_isActive' => 'nullable|string',
            'afficher_montant_pourcentage'        => 'nullable|in:clair,pourcentage,les_deux',
            'ordonner_candidats_votes_decroissants' => 'nullable|string',

            'color_primaire'   => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'color_secondaire' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],

            'condition_participation' => $isUpdate
                ? 'nullable|file|mimes:pdf|max:5120' // Obligatoire au POST (5Mo conseillés pour un PDF)
                : 'required|file|mimes:pdf|max:5120', // Optionnel au UPDATE

            'is_active'               => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            // Nom
            'name.required'                 => 'Le nom de la campagne est obligatoire.',
            'name.string'                   => 'Le nom doit être une chaîne de caractères.',
            'name.max'                      => 'Le nom ne doit pas dépasser 255 caractères.',

            // Description
            'description.required'          => 'La description de la campagne est obligatoire.',

            // Customer
            'customer_id.required'          => 'Veuillez sélectionner un client.',
            'customer_id.exists'            => 'Le client sélectionné est invalide.',

            // Image
            'image_couverture.required'     => 'Une image de couverture est obligatoire.',
            'image_couverture.image'        => 'Le fichier doit être une image.',
            'image_couverture.mimes'        => 'L’image doit être au format jpeg, png ou jpg.',
            'image_couverture.max'          => 'L’image ne doit pas dépasser 3 Mo.',

            // Dates & Heures
            'inscription_date_debut.required_if' => 'La date de début est requise lorsque les inscriptions sont activées.',
            'inscription_date_fin.required_if'   => 'La date de fin est requise lorsque les inscriptions sont activées.',
            'inscription_date_fin.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
            'heure_debut_inscription.required_if' => 'L’heure de début est requise.',
            'heure_fin_inscription.required_if'   => 'L’heure de fin est requise.',

            // Paramètres
            'identifiants_personnalises_isActive.required' => 'Veuillez préciser si les identifiants sont personnalisés.',
            'afficher_montant_pourcentage.required'        => 'Veuillez choisir le mode d’affichage des montants.',
            'afficher_montant_pourcentage.in'              => 'Le mode d’affichage sélectionné est invalide.',
            'ordonner_candidats_votes_decroissants.required' => 'Veuillez préciser l’ordre des candidats.',

            // Couleurs
            'color_primaire.required'       => 'La couleur primaire est obligatoire.',
            'color_primaire.regex'          => 'La couleur primaire doit être un code HEX valide (ex: #FFFFFF).',
            'color_secondaire.required'     => 'La couleur secondaire est obligatoire.',
            'color_secondaire.regex'        => 'La couleur secondaire doit être un code HEX valide (ex: #000000).',

            // Conditions
            'condition_participation.required' => 'Le document des conditions de participation est obligatoire (format PDF).',
            'condition_participation.file'     => 'Le champ doit être un fichier valide.',
            'condition_participation.mimes'    => 'Le document doit être impérativement au format PDF.',
            'condition_participation.max'      => 'Le fichier PDF ne doit pas dépasser 5 Mo.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'text_cover_isActive' => $this->has('text_cover_isActive') ? 1 : 0,
            'inscription_isActive' => $this->has('inscription_isActive') ? 1 : 0,
            'is_active' => $this->has('is_active') ? 1 : 0,
        ]);
    }
}
