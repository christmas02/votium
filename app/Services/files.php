<?php

namespace App\Services;

class Files
{
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

    public static function deleteFile($filename): bool
    {
        $filePath = public_path('uploads/' . $filename);
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}
