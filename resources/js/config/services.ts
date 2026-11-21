import type { ServiceDetail, ServiceItem } from '@/types'

export const HOME_SERVICES: ServiceItem[] = [
    {
        slug: 'construction-generale',
        title: 'Construction générale',
        description:
            'Bâtiments résidentiels, commerciaux et industriels : de la préparation du projet à la livraison.',
        icon: 'building2',
    },
    {
        slug: 'construction-metallique',
        title: 'Construction métallique',
        description:
            'Charpentes, sheds, hangars et structures métalliques, avec fabrication et montage.',
        icon: 'hard-hat',
    },
    {
        slug: 'electricite-batiment',
        title: 'Électricité bâtiment',
        description:
            'Installations électriques, tableaux de distribution, éclairage et systèmes associés.',
        icon: 'zap',
    },
    {
        slug: 'travaux-publics',
        title: 'Travaux publics',
        description:
            'Voiries, réseaux divers, terrassement et aménagements.',
        icon: 'landmark',
    },
    {
        slug: 'renovation',
        title: 'Rénovation',
        description:
            'Rénovation complète ou partielle de bâtiments existants, extension et amélioration du bâti.',
        icon: 'home',
    },
    {
        slug: 'consultance',
        title: 'Consultance',
        description:
            'Études techniques, audits et assistance à la maîtrise d’ouvrage.',
        icon: 'globe',
    },
]

export const SERVICES_HERO = {
    title: 'Nos services',
    subtitle:
        'Une gamme de services couvrant la construction, les infrastructures et les prestations associées. Les modalités de chaque intervention sont précisées dans le devis.',
}

export const ALL_SERVICES: ServiceDetail[] = [
    {
        slug: 'construction-generale',
        title: 'Construction générale',
        description:
            'Réalisation de bâtiments résidentiels, commerciaux et industriels. Nous prenons en charge la coordination du projet, de la préparation à la livraison.',
        icon: 'building2',
        deliverables: [
            'Bâtiments résidentiels et villas',
            'Immeubles commerciaux et bureaux',
            'Complexes industriels et entrepôts',
            'Établissements publics (écoles, hôpitaux)',
            'Rénovation et extension de bâtiments',
        ],
        benefits: [
            'Approche clé en main',
            'Suivi du projet',
            'Coordination des intervenants',
            'Communication régulière',
        ],
    },
    {
        slug: 'construction-metallique',
        title: 'Construction métallique',
        description:
            'Fabrication et montage de structures métalliques sur mesure : charpentes, sheds, hangars et ouvrages associés.',
        icon: 'hard-hat',
        deliverables: [
            'Charpentes métalliques pour bâtiments',
            'Sheds, hangars et structures industrielles',
            'Ponts et passerelles métalliques',
            'Garde-corps, escaliers et rampes',
            'Structures pour équipements sportifs',
        ],
        benefits: [
            'Fabrication sur mesure',
            'Montage sur site',
            'Coordination avec les autres corps d’état',
            'Contrôle des assemblages',
        ],
    },
    {
        slug: 'travaux-publics',
        title: 'Travaux publics',
        description:
            'Réalisation de voiries, réseaux divers, terrassements et aménagements pour les collectivités et le secteur privé.',
        icon: 'landmark',
        deliverables: [
            'Voiries et réseaux divers (VRD)',
            'Routes et pistes rurales',
            'Aménagements urbains',
            'Terrassement et nivellement',
            'Réseaux d’assainissement',
        ],
        benefits: [
            'Coordination des travaux',
            'Prise en compte de l’environnement du site',
            'Suivi des étapes',
            'Communication avec le maître d’ouvrage',
        ],
    },
    {
        slug: 'electricite-batiment',
        title: 'Électricité bâtiment',
        description:
            'Installations électriques pour bâtiments : conception, réalisation et maintenance des réseaux.',
        icon: 'zap',
        deliverables: [
            'Installations électriques intérieures',
            'Tableaux de distribution et comptage',
            'Éclairage intérieur et extérieur',
            'Systèmes de sécurité et alarmes',
            'Mise aux normes et rénovation',
        ],
        benefits: [
            'Installations adaptées au bâtiment',
            'Coordination avec les autres lots',
            'Suivi des essais',
            'Maintenance et accompagnement',
        ],
    },
    {
        slug: 'production-de-materiaux',
        title: 'Production de matériaux',
        description:
            'Production et fourniture de matériaux de construction, avec suivi de la qualité et de la disponibilité.',
        icon: 'factory',
        deliverables: [
            'Blocs de béton et agglomérés',
            'Fer à béton et armatures',
            'Produits métalliques sur mesure',
            'Mortiers et bétons préparés',
            'Éléments préfabriqués',
        ],
        benefits: [
            'Suivi de la qualité',
            'Disponibilité des produits',
            'Livraison sur chantier',
            'Conseil technique',
        ],
    },
    {
        slug: 'travaux-miniers',
        title: 'Travaux miniers',
        description:
            'Prestations pour le secteur minier : infrastructures de surface, génie civil et aménagements spécifiques.',
        icon: 'cog',
        deliverables: [
            'Infrastructures de surface',
            'Génie civil minier',
            'Bassins de décantation',
            'Voiries minières',
            'Bâtiments industriels miniers',
        ],
        benefits: [
            'Prise en compte des contraintes du site',
            'Respect des procédures de sécurité',
            'Coordination des intervenants',
            'Adaptation au contexte',
        ],
    },
    {
        slug: 'adduction-eau-potable',
        title: 'Adduction d’eau potable',
        description:
            'Installation de systèmes d’adduction d’eau potable pour les collectivités et les particuliers.',
        icon: 'droplets',
        deliverables: [
            'Réseaux de distribution d’eau',
            'Châteaux d’eau et réservoirs',
            'Forages et pompages',
            'Systèmes de traitement',
            'Raccordements particuliers',
        ],
        benefits: [
            'Solution complète',
            'Choix des matériaux',
            'Maintenance préventive',
            'Accompagnement technique',
        ],
    },
    {
        slug: 'soudure',
        title: 'Soudure',
        description:
            'Prestations de soudure pour ouvrages métalliques : assemblages, réparation et maintenance.',
        icon: 'hammer',
        deliverables: [
            'Soudure de charpentes et structures',
            'Assemblage de pièces métalliques',
            'Réparation et maintenance',
            'Soudure inox et aluminium',
            'Tuyauterie industrielle',
        ],
        benefits: [
            'Travail en atelier et sur site',
            'Contrôle des assemblages',
            'Matériel adapté',
            'Suivi des travaux',
        ],
    },
    {
        slug: 'consultance',
        title: 'Consultance',
        description:
            'Services de conseil technique et d’assistance à la maîtrise d’ouvrage pour la planification et la gestion de projets.',
        icon: 'globe',
        deliverables: [
            'Études de faisabilité',
            'Audits techniques',
            'Assistance à la maîtrise d’ouvrage',
            'Contrôle technique des constructions',
            'Expertises et diagnostics',
        ],
        benefits: [
            'Regard technique externe',
            'Rapports exploitables',
            'Approche indépendante',
            'Accompagnement personnalisé',
        ],
    },
    {
        slug: 'peinture',
        title: 'Peinture',
        description:
            'Travaux de peinture intérieure et extérieure pour bâtiments, avec préparation des supports et finitions.',
        icon: 'paintbrush',
        deliverables: [
            'Peinture intérieure et extérieure',
            'Revêtements muraux décoratifs',
            'Traitement des façades',
            'Peinture industrielle (métal)',
            'Marquage au sol et signalétique',
        ],
        benefits: [
            'Finitions soignées',
            'Préparation des supports',
            'Respect du planning',
            'Propreté du chantier',
        ],
    },
    {
        slug: 'commerce-de-pieces',
        title: 'Commerce de pièces',
        description:
            'Distribution de pièces détachées et d’équipements pour le bâtiment et la construction métallique.',
        icon: 'shopping-cart',
        deliverables: [
            'Quincaillerie et ferronnerie',
            'Équipements de protection',
            'Outillage professionnel',
            'Pièces détachées métalliques',
            'Accessoires de construction',
        ],
        benefits: [
            'Gamme de produits',
            'Disponibilité',
            'Livraison',
            'Conseil technique',
        ],
    },
    {
        slug: 'agro-pastoral',
        title: 'Agro-pastoral',
        description:
            'Conception et réalisation d’infrastructures agricoles et d’élevage.',
        icon: 'sprout',
        deliverables: [
            'Infrastructures agricoles',
            'Bâtiments d’élevage',
            'Systèmes d’irrigation',
            'Stocks et entrepôts agricoles',
            'Aménagements fonciers',
        ],
        benefits: [
            'Approche intégrée',
            'Prise en compte de l’environnement',
            'Durabilité des installations',
            'Accompagnement technique',
        ],
    },
]

export const SERVICES_PROCESS = [
    {
        step: 1,
        title: 'Prise de contact',
        description: 'Vous nous présentez votre projet et vos besoins.',
        icon: 'phone',
    },
    {
        step: 2,
        title: 'Étude et devis',
        description: 'Nous analysons votre demande et vous transmettons les éléments utiles.',
        icon: 'file-text',
    },
    {
        step: 3,
        title: 'Planification',
        description: 'Les étapes, les responsabilités et le calendrier sont clarifiés.',
        icon: 'calendar',
    },
    {
        step: 4,
        title: 'Réalisation',
        description: 'Exécution des travaux selon le cahier des charges convenu.',
        icon: 'hard-hat',
    },
    {
        step: 5,
        title: 'Livraison',
        description: 'Réception des travaux et accompagnement après livraison.',
        icon: 'circle-check',
    },
]

export const SERVICES_FAQ = [
    {
        question: 'Comment demander un devis ?',
        answer: 'Utilisez le formulaire de contact en choisissant le sujet « Demande de devis ». Précisez votre besoin, la localisation et, si possible, les éléments techniques disponibles.',
    },
    {
        question: 'Quelles informations fournir ?',
        answer: 'La nature du projet, le lieu, les dimensions ou surfaces concernées, le calendrier souhaité et les documents techniques éventuels.',
    },
    {
        question: 'Comment se déroule le suivi ?',
        answer: 'Les modalités de suivi sont définies avec vous avant le démarrage : interlocuteur, fréquence des échanges et étapes de validation.',
    },
    {
        question: 'Quelles zones couvrez-vous ?',
        answer: 'Nous intervenons depuis Durba, dans la province du Haut-Uélé. Les demandes pour d’autres provinces de la République Démocratique du Congo et pour l’Ouganda sont étudiées au cas par cas, en fonction de la localisation et de la nature du projet.',
    },
    {
        question: 'Les modalités de garantie sont-elles précisées ?',
        answer: 'Les conditions applicables sont précisées dans le devis et le contrat.',
    },
]
