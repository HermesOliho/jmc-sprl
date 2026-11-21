<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Identité institutionnelle JMC
    |--------------------------------------------------------------------------
    |
    | Source de vérité pour le nom, la présentation et les coordonnées
    | publiées sur le site. Les informations institutionnelles encore
    | inconnues (identification légale, horaires, coordonnées GPS)
    | restent vides jusqu'à validation par la direction.
    |
    */

    'name' => 'JMC Services S.P.R.L',
    'short_name' => 'JMC Services',
    'legal_name' => 'JMC Services S.P.R.L',
    'tagline' => 'Construction, infrastructures et services',
    'slogan' => 'Building Progress, Moving Possibilities, Delivering Excellence',
    'description' => 'JMC Services S.P.R.L est une entreprise de services active en République Démocratique du Congo, avec une implantation à Durba, dans la province du Haut-Uélé. Elle intervient dans les domaines de la construction, des infrastructures et des services associés.',

    'url' => rtrim((string) env('APP_URL', 'http://localhost'), '/'),
    'locale' => 'fr_CD',

    'logo' => '/logo.svg',
    'logo_dark' => '/logo_for_dark_bg.png',
    'og_image' => '/og/jmc-default.jpg',

    'contact' => [
        'address' => [
            'street' => '',
            'city' => 'Durba',
            'province' => 'Haut-Uélé',
            'country' => 'République Démocratique du Congo',
            'postalCode' => '',
        ],
        'phones' => [
            [
                'label' => 'Congo',
                'display' => '+243 992 863 895',
                'e164' => '+243992863895',
                'area' => 'CD',
            ],
            [
                'label' => 'Congo fixe',
                'display' => '+243 862 386 714',
                'e164' => '+243862386714',
                'area' => 'CD',
            ],
            [
                'label' => 'Ouganda',
                'display' => '+256 708 752 780',
                'e164' => '+256708752780',
                'area' => 'UG',
            ],
        ],
        'whatsapp' => [
            'label' => 'WhatsApp',
            'display' => '+243 980 637 512',
            'e164' => '+243980637512',
            'url' => 'https://wa.me/243980637512',
        ],
        'email' => 'contact@jmcservices.com',
        'website' => 'https://www.jmcservices.com',
        'hours' => '',
        'gps' => null,
    ],

    'social' => [],

    'contact_subjects' => [
        ['value' => 'devis', 'label' => 'Demande de devis'],
        ['value' => 'information', 'label' => "Demande d'information"],
        ['value' => 'partenariat', 'label' => 'Proposition de partenariat'],
        ['value' => 'reclamation', 'label' => 'Réclamation'],
        ['value' => 'stage', 'label' => 'Candidature (stage)'],
        ['value' => 'autre', 'label' => 'Autre'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Métadonnées des pages publiques
    |--------------------------------------------------------------------------
    */

    'pages' => [
        'home' => [
            'title' => 'Accueil',
            'description' => 'JMC Services S.P.R.L — construction, infrastructures et services à Durba, dans le Haut-Uélé, en République Démocratique du Congo.',
            'path' => '/',
            'type' => 'WebPage',
        ],
        'about' => [
            'title' => 'À propos',
            'description' => "Découvrez JMC Services S.P.R.L, ses domaines d'intervention et les principes qui guident son travail.",
            'path' => '/a-propos',
            'type' => 'AboutPage',
        ],
        'services' => [
            'title' => 'Services',
            'description' => 'Découvrez les services de JMC Services S.P.R.L : construction, infrastructures, métallique, électricité et travaux publics.',
            'path' => '/services',
            'type' => 'CollectionPage',
        ],
        'contact' => [
            'title' => 'Contact',
            'description' => 'Contactez JMC Services S.P.R.L pour présenter votre projet ou demander une information.',
            'path' => '/contact',
            'type' => 'ContactPage',
        ],
        'legal' => [
            'title' => 'Mentions légales',
            'description' => 'Informations légales relatives au site de JMC Services S.P.R.L.',
            'path' => '/mentions-legales',
            'type' => 'WebPage',
            'robots' => 'noindex, nofollow',
        ],
        'privacy' => [
            'title' => 'Politique de confidentialité',
            'description' => 'Informations sur la collecte et le traitement des données personnelles par JMC Services S.P.R.L.',
            'path' => '/politique-de-confidentialite',
            'type' => 'WebPage',
            'robots' => 'noindex, nofollow',
        ],
    ],

];
