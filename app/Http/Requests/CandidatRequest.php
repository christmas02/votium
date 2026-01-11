<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CandidatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $candidatId = $this->route('candidat_id') ?? $this->candidat_id;

        return [
            'name'           => 'required|string|max:255',
            'campagne_id'   => 'required|exists:campagnes,campagne_id',
            'etape_id'      => 'required|exists:etapes,etape_id',
            'category_id'   => 'required|exists:categories,category_id',
            'email'          => [
                'required',
                'email',
                'max:255',
                // Même si l'unique n'est pas dans ta migration, 
                // il est fortement conseillé pour des candidats.
                Rule::unique('candidats', 'email')->ignore($candidatId, 'candidat_id')
            ],
            'phonenumber'    => 'required|string|max:20',
            'sexe'           => 'required|in:Masculin,Féminin,Autre', // Force le choix
            'date_naissance' => 'required|date', // Vérifie que c'est une date valide
            'ville'          => 'required|string|max:255',
            'pays'           => 'required|string|max:255',
            'profession'     => 'required|string|max:255',
            
            // Photo : Obligatoire à la création, optionnelle à la modification
            'photo'          => $this->isMethod('post') 
                                ? 'required|image|mimes:jpeg,png,jpg|max:2048' 
                                : 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            
            'description'    => 'required|string|min:30',
            'data'           => 'nullable|string', // Pour stocker du JSON ou texte extra
            'is_active'      => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Le nom complet est obligatoire.',
            'sexe.in'                 => 'Le genre sélectionné n’est pas valide.',
            'date_naissance.required' => 'La date de naissance est requise.',
            'date_naissance.date'     => 'Le format de la date est invalide.',
            'photo.required'          => 'Une photo est obligatoire pour le candidat.',
            'photo.image'             => 'Le fichier doit être une image.',
            'description.min'         => 'La description doit faire au moins 10 caractères.',
        ];
    }
}