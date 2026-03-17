<?php

return [
    'server_error' => 'Une erreur technique est survenue. Veuillez réessayer plus tard ou contacter le support si le problème persiste.',

    /*
    |--------------------------------------------------------------------------
    | Règles génériques Laravel (fallback)
    |--------------------------------------------------------------------------
    */
    'accepted'             => 'Le champ :attribute doit être accepté.',
    'active_url'           => 'Le champ :attribute n\'est pas une URL valide.',
    'after'                => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal'       => 'Le champ :attribute doit être une date égale ou postérieure au :date.',
    'alpha'                => 'Le champ :attribute ne doit contenir que des lettres.',
    'alpha_dash'           => 'Le champ :attribute ne doit contenir que des lettres, chiffres, tirets et underscores.',
    'alpha_num'            => 'Le champ :attribute ne doit contenir que des lettres et des chiffres.',
    'array'                => 'Le champ :attribute doit être un tableau.',
    'before'               => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal'      => 'Le champ :attribute doit être une date égale ou antérieure au :date.',
    'between'              => [
        'numeric' => 'La valeur de :attribute doit être comprise entre :min et :max.',
        'file'    => 'Le fichier :attribute doit peser entre :min et :max kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir entre :min et :max caractères.',
        'array'   => 'Le tableau :attribute doit contenir entre :min et :max éléments.',
    ],
    'boolean'              => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed'            => 'La confirmation du champ :attribute ne correspond pas.',
    'date'                 => 'Le champ :attribute n\'est pas une date valide.',
    'date_equals'          => 'Le champ :attribute doit être une date égale à :date.',
    'date_format'          => 'Le champ :attribute ne correspond pas au format :format.',
    'different'            => 'Les champs :attribute et :other doivent être différents.',
    'digits'               => 'Le champ :attribute doit contenir :digits chiffres.',
    'digits_between'       => 'Le champ :attribute doit contenir entre :min et :max chiffres.',
    'dimensions'           => 'Les dimensions de l\'image :attribute ne sont pas conformes.',
    'distinct'             => 'Le champ :attribute a une valeur en double.',
    'email'                => 'Le champ :attribute doit être une adresse email valide.',
    'ends_with'            => 'Le champ :attribute doit se terminer par : :values.',
    'exists'               => 'La valeur sélectionnée pour :attribute est invalide.',
    'file'                 => 'Le champ :attribute doit être un fichier.',
    'filled'               => 'Le champ :attribute doit avoir une valeur.',
    'gt'                   => [
        'numeric' => 'La valeur de :attribute doit être supérieure à :value.',
        'file'    => 'Le fichier :attribute doit peser plus de :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir plus de :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir plus de :value éléments.',
    ],
    'gte'                  => [
        'numeric' => 'La valeur de :attribute doit être supérieure ou égale à :value.',
        'file'    => 'Le fichier :attribute doit peser au moins :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir au moins :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir au moins :value éléments.',
    ],
    'image'                => 'Le champ :attribute doit être une image (jpeg, png, jpg, gif ou svg).',
    'in'                   => 'La valeur sélectionnée pour :attribute est invalide.',
    'in_array'             => 'Le champ :attribute n\'existe pas dans :other.',
    'integer'              => 'Le champ :attribute doit être un entier.',
    'ip'                   => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4'                 => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json'                 => 'Le champ :attribute doit être un JSON valide.',
    'lt'                   => [
        'numeric' => 'La valeur de :attribute doit être inférieure à :value.',
        'file'    => 'Le fichier :attribute doit peser moins de :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir moins de :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir moins de :value éléments.',
    ],
    'lte'                  => [
        'numeric' => 'La valeur de :attribute doit être inférieure ou égale à :value.',
        'file'    => 'Le fichier :attribute doit peser au plus :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir au plus :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir au plus :value éléments.',
    ],
    'max'                  => [
        'numeric' => 'La valeur de :attribute ne peut pas être supérieure à :max.',
        'file'    => 'Le fichier :attribute ne peut pas dépasser :max kilo-octets.',
        'string'  => 'Le texte :attribute ne peut pas contenir plus de :max caractères.',
        'array'   => 'Le tableau :attribute ne peut pas avoir plus de :max éléments.',
    ],
    'mimes'                => 'Le champ :attribute doit être un fichier de type : :values.',
    'mimetypes'            => 'Le champ :attribute doit être un fichier de type : :values.',
    'min'                  => [
        'numeric' => 'La valeur de :attribute doit être supérieure ou égale à :min.',
        'file'    => 'Le fichier :attribute doit peser au moins :min kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir au moins :min caractères.',
        'array'   => 'Le tableau :attribute doit avoir au moins :min éléments.',
    ],
    'not_in'               => 'La valeur sélectionnée pour :attribute est invalide.',
    'not_regex'            => 'Le format du champ :attribute est invalide.',
    'numeric'              => 'Le champ :attribute doit être un nombre.',
    'password'             => 'Le mot de passe est incorrect.',
    'present'              => 'Le champ :attribute doit être présent.',
    'regex'                => 'Le format du champ :attribute est invalide.',
    'required'             => 'Le champ :attribute est obligatoire.',
    'required_if'          => 'Le champ :attribute est obligatoire quand :other vaut :value.',
    'required_unless'      => 'Le champ :attribute est obligatoire sauf si :other est :values.',
    'required_with'        => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_with_all'    => 'Le champ :attribute est obligatoire quand :values sont présents.',
    'required_without'     => 'Le champ :attribute est obligatoire quand :values n\'est pas présent.',
    'required_without_all' => 'Le champ :attribute est obligatoire quand aucun de :values n\'est présent.',
    'same'                 => 'Les champs :attribute et :other doivent être identiques.',
    'size'                 => [
        'numeric' => 'La valeur de :attribute doit être :size.',
        'file'    => 'Le fichier :attribute doit peser :size kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir :size caractères.',
        'array'   => 'Le tableau :attribute doit contenir :size éléments.',
    ],
    'starts_with'          => 'Le champ :attribute doit commencer par : :values.',
    'string'               => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone'             => 'Le champ :attribute doit être un fuseau horaire valide.',
    'unique'               => 'La valeur du champ :attribute est déjà utilisée.',
    'uploaded'             => 'Le fichier :attribute n\'a pas pu être téléchargé. Vérifiez que sa taille ne dépasse pas la limite autorisée.',
    'url'                  => 'Le champ :attribute doit être une URL valide (ex: https://exemple.com).',
    'uuid'                 => 'Le champ :attribute doit être un UUID valide.',

    /*
    |--------------------------------------------------------------------------
    | Messages personnalisés par champ — tous vos FormRequests
    |--------------------------------------------------------------------------
    */
    'custom' => [

        // ── CustomerRequest ──────────────────────────────────────────────────
        'entreprise' => [
            'required' => 'Le nom de l\'entreprise est obligatoire.',
            'string'   => 'Le nom de l\'entreprise doit être une chaîne de caractères.',
            'max'      => 'Le nom de l\'entreprise ne peut pas dépasser 255 caractères.',
        ],
        'pays_siege' => [
            'required' => 'Le pays du siège est obligatoire.',
            'max'      => 'Le nom du pays est trop long (100 caractères max).',
        ],
        'adresse' => [
            'required' => 'L\'adresse est obligatoire.',
            'max'      => 'L\'adresse ne peut pas dépasser 255 caractères.',
        ],
        'phonenumber' => [
            'required' => 'Le numéro de téléphone est obligatoire.',
            'string'   => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'max'      => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
        ],
        'user_id' => [
            'required' => 'L\'utilisateur associé est requis.',
            'string'   => 'L\'identifiant utilisateur est invalide.',
        ],
        'logo' => [
            'required' => 'Le logo de l\'entreprise est obligatoire.',
            'image'    => 'Le logo doit être un fichier image.',
            'mimes'    => 'Le logo doit être au format : jpeg, png ou jpg.',
            'max'      => 'Le logo est trop lourd (maximum 2 Mo).',
            'uploaded' => 'Le logo n\'a pas pu être téléchargé. Vérifiez que sa taille ne dépasse pas 2 Mo.',
        ],

        // ── Réseaux sociaux (CustomerRequest) ────────────────────────────────
        'link_facebook' => [
            'url' => 'Le lien Facebook doit être une URL valide (ex: https://facebook.com/...).',
            'max' => 'Le lien Facebook est trop long.',
        ],
        'link_instagram' => [
            'url' => 'Le lien Instagram doit être une URL valide.',
            'max' => 'Le lien Instagram est trop long.',
        ],
        'link_tiktok' => [
            'url' => 'Le lien TikTok doit être une URL valide.',
            'max' => 'Le lien TikTok est trop long.',
        ],
        'link_youtube' => [
            'url' => 'Le lien YouTube doit être une URL valide.',
            'max' => 'Le lien YouTube est trop long.',
        ],
        'link_linkedin' => [
            'url' => 'Le lien LinkedIn doit être une URL valide.',
            'max' => 'Le lien LinkedIn est trop long.',
        ],
        'link_website' => [
            'url' => 'Le lien du site web doit être une URL valide.',
            'max' => 'Le lien du site web est trop long.',
        ],

        // ── UserRequest ───────────────────────────────────────────────────────
        'name' => [
            'required' => 'Le nom est obligatoire.',
            'string'   => 'Le nom doit être une chaîne de caractères.',
            'max'      => 'Le nom ne peut pas dépasser 255 caractères.',
        ],
        'email' => [
            'required' => 'L\'adresse e-mail est obligatoire.',
            'email'    => 'Veuillez saisir une adresse e-mail valide.',
            'max'      => 'L\'adresse e-mail est trop longue (255 caractères max).',
            'unique'   => 'Cette adresse e-mail est déjà utilisée.',
        ],
        'password' => [
            'required'  => 'Le mot de passe est obligatoire.',
            'confirmed' => 'Les deux mots de passe ne correspondent pas.',
            'min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'nullable'  => '',
        ],

        // ── CandidatRequest ───────────────────────────────────────────────────
        'telephone' => [
            'required' => 'Le numéro de téléphone est obligatoire.',
            'string'   => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'max'      => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
        ],
        'sexe' => [
            'required' => 'Veuillez sélectionner le genre du candidat.',
            'string'   => 'Le genre sélectionné est invalide.',
            'in'       => 'Le genre sélectionné n\'est pas valide.',
        ],
        'date_naissance' => [
            'required' => 'La date de naissance est obligatoire.',
            'date'     => 'Le format de la date de naissance est invalide.',
        ],
        'ville' => [
            'required' => 'La ville est obligatoire.',
            'max'      => 'Le nom de la ville est trop long.',
        ],
        'pays' => [
            'required' => 'Le pays est obligatoire.',
            'max'      => 'Le nom du pays est trop long.',
        ],
        'profession' => [
            'required' => 'La profession est obligatoire.',
            'max'      => 'La profession ne peut pas dépasser 255 caractères.',
        ],
        'photo' => [
            'required' => 'Une photo est obligatoire pour l\'inscription du candidat.',
            'image'    => 'Le fichier doit être une image.',
            'mimes'    => 'La photo doit être au format : jpeg, png ou jpg.',
            'max'      => 'La photo ne doit pas dépasser 2 Mo.',
            'uploaded' => 'La photo n\'a pas pu être téléchargée. Vérifiez que sa taille ne dépasse pas 2 Mo.',
        ],
        'description' => [
            'required' => 'La description ou biographie est obligatoire.',
            'string'   => 'La description doit être une chaîne de caractères.',
            'max'      => 'La description ne doit pas dépasser 500 caractères.',
        ],

        // ── CampagneRequest ───────────────────────────────────────────────────
        'customer_id' => [
            'required' => 'Veuillez sélectionner un client.',
            'exists'   => 'Le client sélectionné est invalide.',
        ],
        'image_couverture' => [
            'required' => 'Une image de couverture est obligatoire.',
            'image'    => 'Le fichier doit être une image.',
            'mimes'    => 'L\'image doit être au format : jpeg, png ou jpg.',
            'max'      => 'L\'image de couverture ne doit pas dépasser 3 Mo.',
            'uploaded' => 'L\'image de couverture n\'a pas pu être téléchargée. Vérifiez que sa taille ne dépasse pas 3 Mo.',
        ],
        'inscription_date_debut' => [
            'required_if' => 'La date de début d\'inscription est requise lorsque les inscriptions sont activées.',
            'date'        => 'La date de début d\'inscription est invalide.',
        ],
        'inscription_date_fin' => [
            'required_if'     => 'La date de fin d\'inscription est requise lorsque les inscriptions sont activées.',
            'date'            => 'La date de fin d\'inscription est invalide.',
            'after_or_equal'  => 'La date de fin doit être égale ou postérieure à la date de début.',
        ],
        'heure_debut_inscription' => [
            'required_if' => 'L\'heure de début est requise lorsque les inscriptions sont activées.',
        ],
        'heure_fin_inscription' => [
            'required_if' => 'L\'heure de fin est requise lorsque les inscriptions sont activées.',
        ],
        'color_primaire' => [
            'regex' => 'La couleur primaire doit être un code HEX valide (ex: #FFFFFF).',
        ],
        'color_secondaire' => [
            'regex' => 'La couleur secondaire doit être un code HEX valide (ex: #000000).',
        ],
        'condition_participation' => [
            'required' => 'Le document des conditions de participation est obligatoire (format PDF).',
            'file'     => 'Le champ doit être un fichier valide.',
            'mimes'    => 'Le document des conditions doit impérativement être au format PDF.',
            'max'      => 'Le fichier PDF des conditions ne doit pas dépasser 5 Mo.',
            'uploaded' => 'Le fichier PDF n\'a pas pu être téléchargé. Vérifiez que sa taille ne dépasse pas 5 Mo.',
        ],

        // ── EtapeRequest ──────────────────────────────────────────────────────
        'campagne_id' => [
            'required' => 'La campagne est obligatoire.',
            'exists'   => 'La campagne sélectionnée est invalide.',
        ],
        'date_debut' => [
            'required' => 'La date de début est obligatoire.',
            'date'     => 'Le format de la date de début est invalide.',
        ],
        'date_fin' => [
            'required'        => 'La date de fin est obligatoire.',
            'date'            => 'Le format de la date de fin est invalide.',
            'after_or_equal'  => 'La date de fin doit être égale ou postérieure à la date de début.',
        ],
        'heure_debut' => [
            'required' => 'L\'heure de début est obligatoire.',
        ],
        'heure_fin' => [
            'required' => 'L\'heure de fin est obligatoire.',
        ],
        'prix_vote' => [
            'required' => 'Le prix du vote est obligatoire.',
            'numeric'  => 'Le prix du vote doit être un montant numérique valide.',
            'min'      => 'Le prix du vote ne peut pas être négatif.',
        ],
        'seuil_selection' => [
            'numeric' => 'Le seuil de sélection doit être un nombre.',
            'min'     => 'Le seuil de sélection ne peut pas être négatif.',
        ],

        // ── CategoryCampagneRequest ───────────────────────────────────────────
        'icon' => [
            'required' => 'Veuillez choisir une icône ou une image.',
            'image'    => 'L\'icône doit être un fichier image.',
            'mimes'    => 'L\'icône doit être au format : jpeg, png ou jpg.',
            'max'      => 'L\'icône ne doit pas dépasser 2 Mo.',
            'uploaded' => 'L\'icône n\'a pas pu être téléchargée. Vérifiez sa taille.',
        ],

        // ── WithdrawalAccountRequest ──────────────────────────────────────────
        'account_name' => [
            'required' => 'Le nom du compte est obligatoire.',
            'string'   => 'Le nom du compte doit être une chaîne de caractères.',
            'min'      => 'Le nom du compte doit contenir au moins 3 caractères.',
            'max'      => 'Le nom du compte ne peut pas dépasser 255 caractères.',
        ],
        'phone_number' => [
            'required' => 'Le numéro de compte ou téléphone est obligatoire.',
            'string'   => 'Le numéro doit être une chaîne de caractères.',
            'min'      => 'Le numéro doit contenir au moins 8 caractères.',
            'max'      => 'Le numéro ne peut pas dépasser 20 caractères.',
        ],
        'payment_methode' => [
            'required' => 'Veuillez sélectionner une méthode de paiement.',
            'string'   => 'La méthode de paiement sélectionnée est invalide.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Noms lisibles des attributs (remplace ":attribute" dans les messages)
    |--------------------------------------------------------------------------
    */
    'attributes' => [
        // Commun
        'name'             => 'nom',
        'email'            => 'adresse e-mail',
        'password'         => 'mot de passe',
        'user_id'          => 'utilisateur',

        // Customer
        'entreprise'       => 'nom de l\'entreprise',
        'pays_siege'       => 'pays du siège',
        'adresse'          => 'adresse',
        'phonenumber'      => 'numéro de téléphone',
        'logo'             => 'logo',
        'link_facebook'    => 'lien Facebook',
        'link_instagram'   => 'lien Instagram',
        'link_tiktok'      => 'lien TikTok',
        'link_youtube'     => 'lien YouTube',
        'link_linkedin'    => 'lien LinkedIn',
        'link_website'     => 'site web',

        // Candidat
        'telephone'        => 'téléphone',
        'sexe'             => 'genre',
        'date_naissance'   => 'date de naissance',
        'ville'            => 'ville',
        'pays'             => 'pays',
        'profession'       => 'profession',
        'photo'            => 'photo',
        'description'      => 'description',

        // Campagne
        'customer_id'                  => 'client',
        'image_couverture'             => 'image de couverture',
        'inscription_date_debut'       => 'date de début d\'inscription',
        'inscription_date_fin'         => 'date de fin d\'inscription',
        'heure_debut_inscription'      => 'heure de début',
        'heure_fin_inscription'        => 'heure de fin',
        'color_primaire'               => 'couleur primaire',
        'color_secondaire'             => 'couleur secondaire',
        'condition_participation'      => 'conditions de participation',
        'afficher_montant_pourcentage' => 'mode d\'affichage des montants',

        // Etape
        'campagne_id'      => 'campagne',
        'date_debut'       => 'date de début',
        'date_fin'         => 'date de fin',
        'heure_debut'      => 'heure de début',
        'heure_fin'        => 'heure de fin',
        'prix_vote'        => 'prix du vote',
        'seuil_selection'  => 'seuil de sélection',
        'package'          => 'package',

        // Catégorie
        'icon'             => 'icône',

        // Compte de retrait
        'account_name'     => 'nom du compte',
        'phone_number'     => 'numéro de téléphone',
        'payment_methode'  => 'méthode de paiement',
    ],

];