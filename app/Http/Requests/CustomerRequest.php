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
        $customerId = $this->route('customer_id') ?? $this->customer_id;

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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'entreprise.required' => 'Le nom de l’entreprise est obligatoire.',
            'email.unique'        => 'Cet email d’entreprise est déjà enregistré.',
            'logo.image'          => 'Le logo doit être une image.',
            'logo.max'            => 'Le logo ne doit pas dépasser 2Mo.',
            // Les messages "url" sont utiles pour forcer le format https://...
            'link_facebook.url'   => 'Le lien Facebook doit être une URL valide.',
            'link_website.url'    => 'Le lien du site web doit être une URL valide.',
        ];
    }
}