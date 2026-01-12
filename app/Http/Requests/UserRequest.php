<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $isUpdate = $this->filled('user_id');
        $userId = $this->input('user_id');
        return [
            'name' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:20',

            'email' => [
                'required',
                'email',
                'max:255',
                // unique:table,colonne,ID_a_ignorer,nom_colonne_ID
                'unique:users,email,' . $userId . ',user_id'
            ],

            'password' => $userId
                ? 'nullable|confirmed|min:8'
                : 'required|confirmed|min:8',

            // 'role' => 'nullable|in:admin,customer,manager',
        ];
    }

    /**
     * Personnalisation des messages d'erreur (Optionnel)
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L’adresse email est obligatoire.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'phonenumber.required' => 'Le numéro de téléphone est requis.',
            'password.required' => 'Le mot de passe est obligatoire pour la création.',
            'password.confirmed' => 'Les deux mots de passe ne correspondent pas.',
            'role.in' => 'Le rôle sélectionné n’est pas valide.',
        ];
    }
}
