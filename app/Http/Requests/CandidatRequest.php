<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CandidatRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $isUpdate = $this->filled('candidat_id');
        $candidatId = $this->input('candidat_id');
        return [
            'name'           => 'required|string|max:255',
            'email'          => [
                'nullable',
                'email',
                'max:255',
                // Même si l'unique n'est pas dans ta migration, 
                // il est fortement conseillé pour des candidats.
                Rule::unique('candidats', 'email')->ignore($candidatId, 'candidat_id')
            ],
            'telephone'    => 'nullable|string|max:20',
            'sexe'           => 'nullable|string', // Force le choix
            'date_naissance' => 'nullable|date', // Vérifie que c'est une date valide
            'ville'          => 'nullable|string|max:255',
            'pays'           => 'nullable|string|max:255',
            'profession'     => 'nullable|string|max:255',

            // Photo : Obligatoire à la création, optionnelle à la modification
            'photo'          => $isUpdate
                ? 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                : 'required|image|mimes:jpeg,png,jpg|max:2048',

            'description'    => 'nullable|string|max:100',
            'data'           => 'nullable|string', // Pour stocker du JSON ou texte extra
        ];
    }

    public function messages(): array
    {
        return [
            // Nom
            'name.required'           => 'Le nom complet du candidat est obligatoire.',
            'name.max'                => 'Le nom ne doit pas dépasser 255 caractères.',

            // Campagne & Etape
            'campagne_id.required'    => 'La campagne est obligatoire.',
            'campagne_id.exists'      => 'La campagne sélectionnée est invalide.',
            'etape_id.required'       => 'L’étape est obligatoire.',
            'etape_id.exists'         => 'L’étape sélectionnée est invalide.',

            // Email
            'email.required'          => 'L’adresse email est obligatoire.',
            'email.email'             => 'Veuillez saisir une adresse email valide.',
            'email.unique'            => 'Cette adresse email est déjà utilisée par un autre candidat.',

            // Infos Perso
            'telephone.required'    => 'Le numéro de téléphone est obligatoire.',
            'sexe.required'           => 'Veuillez sélectionner le genre du candidat.',
            'sexe.in'                 => 'Le genre sélectionné n’est pas valide.',
            'date_naissance.required' => 'La date de naissance est requise.',
            'date_naissance.date'     => 'Le format de la date de naissance est invalide.',
            
            // Localisation
            'ville.required'          => 'La ville est obligatoire.',
            'pays.required'           => 'Le pays est obligatoire.',
            'profession.required'     => 'La profession est obligatoire.',

            // Photo
            'photo.required'          => 'Une photo est obligatoire pour l’inscription du candidat.',
            'photo.image'             => 'Le fichier doit être une image.',
            'photo.mimes'             => 'La photo doit être au format : jpeg, png, jpg.',
            'photo.max'               => 'La photo ne doit pas dépasser 2 Mo.',

            // Description
            'description.required'    => 'La description ou biographie est obligatoire.',
            'description.max'         => 'La description ne doit pas dépasser 500 caractères.',
        ];
    }
}
