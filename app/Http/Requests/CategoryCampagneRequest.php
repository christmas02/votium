<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryCampagneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category_id') ?? $this->category_id;

        return [
            'campagne_id' => 'required|exists:campagnes,campagne_id',
            
            // Nom de la catégorie : unique pour une même campagne
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('category_campagnes', 'name')
                    ->where('campagne_id', $this->campagne_id)
                    ->ignore($categoryId, 'category_id')
            ],

            'description' => 'required|string|max:500',

            // Icône : peut être une image ou un nom de classe (ex: FontAwesome)
            // Si c'est un upload d'image :
            'icon' => $this->isMethod('post') 
                        ? 'required|image|mimes:png,jpg,jpeg,svg|max:1024' 
                        : 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',

            'is_active' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Le nom de la catégorie est obligatoire.',
            'name.unique'          => 'Une catégorie avec ce nom existe déjà pour cette campagne.',
            'campagne_id.exists'   => 'La campagne sélectionnée est invalide.',
            'icon.required'        => 'Veuillez choisir une icône ou une image.',
            'icon.image'           => 'L’icône doit être une image.',
            'description.required' => 'La description est obligatoire.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? '1' : '0',
        ]);
    }
}