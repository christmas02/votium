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
        $isUpdate = $this->filled('category_id');

        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',

            // ICÔNE : Logique dynamique
            'icon' => 'nullable',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Le nom de la catégorie est obligatoire.',
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
