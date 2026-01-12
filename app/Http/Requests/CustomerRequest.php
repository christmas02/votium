<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // On récupère l'ID du customer (soit par la route, soit par le champ caché)
        $isUpdate = $this->filled('customer_id');
        $customerId = $this->input('customer_id');
        return [
            'entreprise'    => 'required|string|max:255',
            'pays_siege'    => 'required|string|max:100',
            'adresse'       => 'required|string|max:255',
            'phonenumber'   => 'required|string|max:255',
            'user_id'       => 'required|string', // Si c'est un UUID d'utilisateur

            // Email unique mais ignore le customer actuel lors de l'update
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customerId, 'customer_id')
            ],

            // Validation des réseaux sociaux (nullable + format URL)
            'link_facebook'  => 'nullable|url|max:255',
            'link_instagram' => 'nullable|url|max:255',
            'link_tiktok'    => 'nullable|url|max:255',
            'link_youtube'   => 'nullable|url|max:255',
            'link_linkedin'  => 'nullable|url|max:255',
            'link_website'   => 'nullable|url|max:255',

            // Validation du logo (si c'est un fichier uploadé)
            'logo' =>  $isUpdate
                ? 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                : 'required|image|mimes:jpeg,png,jpg|max:2048',

        ];
    }

    public function messages(): array
    {
        return [
            // Entreprise
            'entreprise.required'  => 'Le nom de l’entreprise est obligatoire.',
            'entreprise.string'    => 'Le nom de l’entreprise doit être une chaîne de caractères.',
            'entreprise.max'       => 'Le nom de l’entreprise ne peut pas dépasser 255 caractères.',

            // Pays
            'pays_siege.required'  => 'Le pays du siège est obligatoire.',
            'pays_siege.max'       => 'Le nom du pays est trop long.',

            // Adresse
            'adresse.required'     => 'L’adresse est obligatoire.',

            // Téléphone
            'phonenumber.required' => 'Le numéro de téléphone est obligatoire.',

            // Utilisateur
            'user_id.required'     => 'L’utilisateur associé est requis.',

            // Email
            'email.required'       => 'L’adresse e-mail est obligatoire.',
            'email.email'          => 'Veuillez saisir une adresse e-mail valide.',
            'email.max'            => 'L’adresse e-mail est trop longue.',
            'email.unique'         => 'Cette adresse e-mail est déjà utilisée par un autre client.',

            // Réseaux Sociaux
            'link_facebook.url'    => 'Le lien Facebook doit être une URL valide (ex: https://...).',
            'link_instagram.url'   => 'Le lien Instagram doit être une URL valide.',
            'link_tiktok.url'      => 'Le lien TikTok doit être une URL valide.',
            'link_youtube.url'     => 'Le lien YouTube doit être une URL valide.',
            'link_linkedin.url'    => 'Le lien LinkedIn doit être une URL valide.',
            'link_website.url'     => 'Le lien du site web doit être une URL valide.',

            // Logo
            'logo.image'           => 'Le logo doit être un fichier image.',
            'logo.mimes'           => 'Le logo doit être au format : jpeg, png, jpg, gif ou svg.',
            'logo.max'             => 'Le logo est trop lourd (maximum 2 Mo).',
        ];
    }
}
