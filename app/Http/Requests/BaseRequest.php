<?php
// app/Http/Requests/BaseRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseRequest extends FormRequest
{
    protected array $uploadedFallbacks = [];

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->toArray();

        $fallbackMessages = array_merge([
            'validation.uploaded' => 'Le fichier n\'a pas pu être envoyé. Vérifiez que sa taille ne dépasse pas la limite autorisée.',
            'validation.image'    => 'Le fichier doit être une image valide (jpeg, png, jpg).',
            'validation.mimes'    => 'Le format du fichier n\'est pas autorisé.',
            'validation.required' => 'Ce champ est obligatoire.',
            'validation.email'    => 'Veuillez saisir une adresse e-mail valide.',
            'validation.unique'   => 'Cette valeur est déjà utilisée.',
            'validation.max.file' => 'Le fichier dépasse la taille maximale autorisée.',
        ], $this->uploadedFallbacks); // ← chaque Request peut ajouter ses propres overrides

        foreach ($errors as $field => $messages) {
            foreach ($messages as $index => $message) {
                if (isset($fallbackMessages[$message])) {
                    $errors[$field][$index] = $fallbackMessages[$message];
                }
            }
        }

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Veuillez corriger les champs en erreur.',
                'errors'  => $errors,
            ], 422)
        );
    }
}