import type { ServiceDetail, ServiceItem } from '@/types'

export const HOME_SERVICES: ServiceItem[] = [
    {
        title: 'Construction Générale',
        description:
            'Bâtiments résidentiels, commerciaux et industriels clés en main. De la fondation à la livraison, nous assurons chaque étape avec rigueur.',
        icon: 'building2',
    },
    {
        title: 'Construction Métallique',
        description:
            'Charpentes métalliques, sheds, hangars et structures sur mesure. Fabrication et montage selon les normes internationales.',
        icon: 'hard-hat',
    },
    {
        title: 'Électricité Bâtiment',
        description:
            'Installations électriques complètes, tableaux de distribution, éclairage et systèmes de sécurité pour tous types de bâtiments.',
        icon: 'zap',
    },
    {
        title: 'Travaux Publics',
        description:
            'Voiries, réseaux divers, terrassement et aménagements urbains. Des infrastructures durables pour le développement.',
        icon: 'landmark',
    },
    {
        title: 'Rénovation',
        description:
            'Rénovation complète ou partielle de bâtiments existants. Mise aux normes, extension et amélioration du bâti.',
        icon: 'home',
    },
    {
        title: 'Consultance',
        description:
            'Études techniques, audits, conseil en construction et assistance à la maîtrise d\'ouvrage pour vos projets.',
        icon: 'globe',
    },
]

export const SERVICES_HERO = {
    title: 'Nos services',
    subtitle:
        'Une gamme complète de services de construction et de métallurgie pour répondre à tous vos besoins, de la conception à la réalisation.',
    image: 'https://placehold.co/1920x800/1a3a5c/ffffff?text=Nos+Services',
}

export const ALL_SERVICES: ServiceDetail[] = [
    {
        slug: 'construction-generale',
        title: 'Construction Générale',
        description:
            'Réalisation de bâtiments résidentiels, commerciaux et industriels clés en main. Nous prenons en charge l\'intégralité de votre projet, de la fondation à la livraison finale.',
        icon: 'building2',
        image: 'https://placehold.co/800x600/1a3a5c/ffffff?text=Construction+G%C3%A9n%C3%A9rale',
        deliverables: [
            'Bâtiments résidentiels et villas',
            'Immeubles commerciaux et bureaux',
            'Complexes industriels et entrepôts',
            'Établissements publics (écoles, hôpitaux)',
            'Rénovation et extension de bâtiments',
        ],
        benefits: [
            'Approche clé en main de A à Z',
            'Respect strict des normes de construction',
            'Suivi de chantier transparent',
            'Garantie décennale incluse',
        ],
    },
    {
        slug: 'construction-metallique',
        title: 'Construction Métallique',
        description:
            'Fabrication et montage de structures métalliques sur mesure. Notre atelier de métallurgie est équipé pour réaliser tous types d\'ouvrages métalliques.',
        icon: 'hard-hat',
        image: 'https://placehold.co/800x600/d4a843/1a3a5c?text=Construction+M%C3%A9tallique',
        deliverables: [
            'Charpentes métalliques pour bâtiments',
            'Sheds, hangars et structures industrielles',
            'Ponts et passerelles métalliques',
            'Garde-corps, escaliers et rampes',
            'Structures pour équipements sportifs',
        ],
        benefits: [
            'Fabrication sur mesure en atelier',
            'Montage rapide sur site',
            'Structures durables et résistantes',
            'Conformité aux normes internationales',
        ],
    },
    {
        slug: 'travaux-publics',
        title: 'Travaux Publics',
        description:
            'Expert en infrastructures publiques, nous réalisons des projets d\'envergure pour le compte de l\'État, des collectivités et du secteur privé.',
        icon: 'landmark',
        image: 'https://placehold.co/800x600/1a3a5c/ffffff?text=Travaux+Publics',
        deliverables: [
            'Voiries et réseaux divers (VRD)',
            'Routes et pistes rurales',
            'Aménagements urbains',
            'Terrassement et nivellement',
            'Réseaux d\'assainissement',
        ],
        benefits: [
            'Maîtrise des grands chantiers',
            'Respect des normes environnementales',
            'Matériel de chantier moderne',
            'Capacité d\'intervention nationale',
        ],
    },
    {
        slug: 'electricite-batiment',
        title: 'Électricité Bâtiment',
        description:
            'Installations électriques complètes pour tous types de bâtiments. Nous assurons la conception, la réalisation et la maintenance de vos réseaux électriques.',
        icon: 'zap',
        image: 'https://placehold.co/800x600/d4a843/1a3a5c?text=%C3%89lectricit%C3%A9+B%C3%A2timent',
        deliverables: [
            'Installations électriques intérieures',
            'Tableaux de distribution et comptage',
            'Éclairage intérieur et extérieur',
            'Systèmes de sécurité et alarmes',
            'Mise aux normes et rénovation',
        ],
        benefits: [
            'Installations conformes aux normes',
            'Matériel certifié de qualité',
            'Intervention rapide',
            'Maintenance et SAV inclus',
        ],
    },
    {
        slug: 'production-de-materiaux',
        title: 'Production de Matériaux',
        description:
            'Production et fourniture de matériaux de construction de haute qualité. Notre unité de production garantit la traçabilité et la conformité des matériaux utilisés.',
        icon: 'factory',
        image: 'https://placehold.co/800x600/1a3a5c/ffffff?text=Production+Mat%C3%A9riaux',
        deliverables: [
            'Blocs de béton et agglomérés',
            'Fer à béton et armatures',
            'Produits métalliques sur mesure',
            'Mortiers et bétons préparés',
            'Éléments préfabriqués',
        ],
        benefits: [
            'Qualité constante et contrôlée',
            'Disponibilité immédiate',
            'Prix compétitifs',
            'Livraison sur chantier',
        ],
    },
    {
        slug: 'travaux-miniers',
        title: 'Travaux Miniers',
        description:
            'Prestations de services pour le secteur minier : infrastructures de surface, génie civil minier et aménagements spécifiques.',
        icon: 'cog',
        image: 'https://placehold.co/800x600/d4a843/1a3a5c?text=Travaux+Minier',
        deliverables: [
            'Infrastructures de surface',
            'Génie civil minier',
            'Bassins de décantation',
            'Voiries minières',
            'Bâtiments industriels miniers',
        ],
        benefits: [
            'Expérience du secteur minier',
            'Respect des normes de sécurité',
            'Intervention en milieu difficile',
            'Flexibilité d\'adaptation',
        ],
    },
    {
        slug: 'adduction-eau-potable',
        title: 'Adduction d\'Eau Potable',
        description:
            'Installation de systèmes d\'adduction d\'eau potable pour les collectivités et les particuliers. Nous contribuons à l\'accès à l\'eau potable dans tout le pays.',
        icon: 'droplets',
        image: 'https://placehold.co/800x600/1a3a5c/ffffff?text=Adduction+Eau',
        deliverables: [
            'Réseaux de distribution d\'eau',
            'Châteaux d\'eau et réservoirs',
            'Forages et pompages',
            'Systèmes de traitement',
            'Raccordements particuliers',
        ],
        benefits: [
            'Solution complète clé en main',
            'Matériaux aux normes OMS',
            'Maintenance préventive incluse',
            'Intervention rapide',
        ],
    },
    {
        slug: 'soudure',
        title: 'Soudure',
        description:
            'Prestations de soudure professionnelle pour tous types d\'ouvrages métalliques. Notre équipe de soudeurs certifiés réalise des assemblages de haute qualité.',
        icon: 'hammer',
        image: 'https://placehold.co/800x600/d4a843/1a3a5c?text=Soudure',
        deliverables: [
            'Soudure de charpentes et structures',
            'Assemblage de pièces métalliques',
            'Réparation et maintenance',
            'Soudure inox et aluminium',
            'Tuyauterie industrielle',
        ],
        benefits: [
            'Soudeurs certifiés et expérimentés',
            'Matériel de soudure moderne',
            'Travail en atelier et sur site',
            'Contrôle qualité systématique',
        ],
    },
    {
        slug: 'consultance',
        title: 'Consultance',
        description:
            'Services de conseil technique et d\'assistance à la maîtrise d\'ouvrage. Nous vous accompagnons dans la planification et la gestion de vos projets.',
        icon: 'globe',
        image: 'https://placehold.co/800x600/1a3a5c/ffffff?text=Consultance',
        deliverables: [
            'Études de faisabilité',
            'Audits techniques',
            'Assistance à la maîtrise d\'ouvrage',
            'Contrôle technique des constructions',
            'Expertises et diagnostics',
        ],
        benefits: [
            'Expertise pluridisciplinaire',
            'Rapports détaillés et exploitables',
            'Indépendance et objectivité',
            'Accompagnement personnalisé',
        ],
    },
    {
        slug: 'peinture',
        title: 'Peinture',
        description:
            'Travaux de peinture intérieure et extérieure pour tous types de bâtiments. Finitions soignées et durables pour un rendu esthétique professionnel.',
        icon: 'paintbrush',
        image: 'https://placehold.co/800x600/d4a843/1a3a5c?text=Peinture',
        deliverables: [
            'Peinture intérieure et extérieure',
            'Revêtements muraux décoratifs',
            'Traitement des façades',
            'Peinture industrielle (métal)',
            'Marquage au sol et signalétique',
        ],
        benefits: [
            'Finitions professionnelles',
            'Peintures de qualité supérieure',
            'Respect des délais',
            'Propreté et soin du chantier',
        ],
    },
    {
        slug: 'commerce-de-pieces',
        title: 'Commerce de Pièces',
        description:
            'Distribution et vente de pièces détachées et d\'équipements pour le bâtiment et la construction métallique. Un stock important pour une disponibilité immédiate.',
        icon: 'shopping-cart',
        image: 'https://placehold.co/800x600/1a3a5c/ffffff?text=Commerce+Pi%C3%A8ces',
        deliverables: [
            'Quincaillerie et ferronnerie',
            'Équipements de protection',
            'Outillage professionnel',
            'Pièces détachées métalliques',
            'Accessoires de construction',
        ],
        benefits: [
            'Large gamme de produits',
            'Stock permanent et varié',
            'Livraison rapide',
            'Conseil technique inclus',
        ],
    },
    {
        slug: 'agro-pastoral',
        title: 'Agro-pastoral',
        description:
            'Développement de projets agro-pastoraux intégrés. Nous concevons et réalisons des infrastructures agricoles et d\'élevage modernes et durables.',
        icon: 'sprout',
        image: 'https://placehold.co/800x600/d4a843/1a3a5c?text=Agro-pastoral',
        deliverables: [
            'Infrastructures agricoles',
            'Bâtiments d\'élevage',
            'Systèmes d\'irrigation',
            'Stocks et entrepôts agricoles',
            'Aménagements fonciers',
        ],
        benefits: [
            'Approche intégrée',
            'Respect de l\'environnement',
            'Durabilité des installations',
            'Accompagnement technique',
        ],
    },
]

export const SERVICES_PROCESS = [
    {
        step: 1,
        title: 'Prise de contact',
        description: 'Vous nous exposez votre projet et vos besoins.',
        icon: 'phone',
    },
    {
        step: 2,
        title: 'Étude et devis',
        description: 'Nous analysons votre demande et vous fournissons un devis détaillé.',
        icon: 'file-text',
    },
    {
        step: 3,
        title: 'Planification',
        description: 'Établissement du planning et préparation du chantier.',
        icon: 'calendar',
    },
    {
        step: 4,
        title: 'Réalisation',
        description: 'Exécution des travaux selon le cahier des charges.',
        icon: 'hard-hat',
    },
    {
        step: 5,
        title: 'Livraison',
        description: 'Réception du chantier et suivi post-livraison.',
        icon: 'circle-check',
    },
]

export const SERVICES_FAQ = [
    {
        question: 'Comment obtenir un devis ?',
        answer: 'Vous pouvez nous contacter via notre formulaire en ligne, par téléphone ou par email. Nous vous répondrons sous 48h avec un devis détaillé et personnalisé.',
    },
    {
        question: 'Quels sont vos délais d\'intervention ?',
        answer: 'Les délais varient selon la nature et l\'ampleur du projet. Nous établissons un planning précis avant le début des travaux et nous nous engageons à le respecter.',
    },
    {
        question: 'Proposez-vous une garantie sur vos travaux ?',
        answer: 'Oui, tous nos travaux sont couverts par une garantie décennale et une assurance responsabilité civile professionnelle.',
    },
    {
        question: 'Intervenez-vous dans toute la RDC ?',
        answer: 'Oui, nous intervenons dans toutes les provinces de la RDC. Nous avons déjà réalisé des projets à Kinshasa, Lubumbashi, Goma, Mbuji-Mayi et dans plusieurs autres villes.',
    },
    {
        question: 'Puis-je suivre l\'avancement de mon chantier ?',
        answer: 'Absolument. Nous mettons en place un reporting régulier avec des comptes rendus photographiques et des réunions de suivi tout au long du projet.',
    },
]
