<?php

namespace App\Services;

class Upload
{
    // public static function uploadFile($file): string
    // {
    //     $fichier_name = time() . '.' . $file->getClientOriginalName();
    //     $file->move(public_path('uploads'), $fichier_name);
    //     return $fichier_name;
    // }

    public static function uploadFile($file): string
    {
        // Récupérer le nom original sans l'extension
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Remplacer les espaces par des underscores et supprimer les caractères spéciaux
        $safeName = preg_replace('/[^A-Za-z0-9\-]/', '_', $originalName);

        // Récupérer l'extension du fichier
        $extension = $file->getClientOriginalExtension();

        // Préfixe avec le timestamp
        $filename = time() . '_' . $safeName . '.' . $extension;

        // Déplacer le fichier dans le dossier public/uploads
        $file->move(public_path('uploads'), $filename);

        return $filename;
    }
}
