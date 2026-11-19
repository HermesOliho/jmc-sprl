import type { HistoryItem, CompanyValue, MissionVision } from '@/types'

export const ABOUT_HERO = {
    title: 'À propos de CCM SARL',
    subtitle:
        'Découvrez l\'histoire, les valeurs et la vision d\'une entreprise congolaise engagée dans l\'excellence du BTP depuis plus de 15 ans.',
    image: 'https://placehold.co/1920x800/1a3a5c/ffffff?text=%C3%80+propos+de+CCM+SARL',
}

export const ABOUT_PRESENTATION = {
    title: 'Une référence congolaise dans le BTP',
    content: `Congo Construction & Métallique SARL (CCM SARL) est une entreprise congolaise spécialisée dans la construction générale, la construction métallique, les travaux publics, l'électricité bâtiment et la consultance technique.

Fondée il y a plus de 15 ans, CCM SARL s'est imposée comme un acteur incontournable du secteur du BTP en République Démocratique du Congo. Notre expertise couvre l'ensemble de la chaîne de valeur de la construction, de la conception à la livraison des projets.

Nous intervenons sur des projets d'envergure nationale : bâtiments publics et privés, infrastructures routières, construction métallique, réseaux électriques et adduction d'eau potable. Chaque projet est pour nous l'opportunité de démontrer notre savoir-faire et notre engagement.`,
}

export const ABOUT_HISTORY: HistoryItem[] = [
    {
        year: '2009',
        title: 'Création de CCM SARL',
        description:
            'Fondation de l\'entreprise par des ingénieurs congolais passionnés, avec une vision claire : bâtir un Congo moderne avec des standards internationaux.',
        icon: 'star',
    },
    {
        year: '2012',
        title: 'Premiers grands projets',
        description:
            'Réalisation des premières infrastructures publiques et privées, marquant l\'entrée de CCM SARL sur le marché national du BTP.',
        icon: 'building2',
    },
    {
        year: '2015',
        title: 'Expansion régionale',
        description:
            'Extension des activités à plusieurs provinces de la RDC, avec l\'ouverture de nouveaux chantiers et le recrutement d\'équipes locales.',
        icon: 'globe',
    },
    {
        year: '2018',
        title: 'Diversification des services',
        description:
            'Lancement de nouvelles divisions : électricité bâtiment, production de matériaux et consultance technique pour offrir une gamme complète.',
        icon: 'zap',
    },
    {
        year: '2021',
        title: 'Certifications et reconnaissance',
        description:
            'Obtention de certifications qualité et sécurité. CCM SARL devient un partenaire privilégié des donneurs d\'ordre publics et privés.',
        icon: 'award',
    },
    {
        year: '2024',
        title: 'CCM SARL aujourd\'hui',
        description:
            'Plus de 150 projets réalisés, 200 collaborateurs, et une présence active dans tout le pays. CCM SARL continue d\'innover pour un développement durable.',
        icon: 'trending-up',
    },
]

export const ABOUT_VALUES: CompanyValue[] = [
    {
        title: 'Qualité',
        description:
            'Nous sélectionnons rigoureusement nos matériaux et contrôlons chaque étape de réalisation pour garantir des finitions irréprochables.',
        icon: 'star',
    },
    {
        title: 'Innovation',
        description:
            'Nous adoptons les techniques et technologies les plus récentes pour optimiser nos processus et offrir des solutions modernes.',
        icon: 'trending-up',
    },
    {
        title: 'Sécurité',
        description:
            'La sécurité de nos équipes et de nos chantiers est une priorité absolue. Nous appliquons des normes strictes et formons continuellement notre personnel.',
        icon: 'shield-check',
    },
    {
        title: 'Professionnalisme',
        description:
            'Rigueur, transparence et respect des engagements sont les piliers de notre relation avec nos clients et partenaires.',
        icon: 'briefcase',
    },
    {
        title: 'Engagement',
        description:
            'Nous nous engageons pleinement dans chaque projet, avec une implication totale pour atteindre les objectifs fixés, quels que soient les défis.',
        icon: 'heart',
    },
    {
        title: 'Respect',
        description:
            'Respect des délais, des normes environnementales, des communautés locales et de chaque collaborateur. C\'est la base de notre éthique.',
        icon: 'users',
    },
]

export const ABOUT_MISSION: MissionVision = {
    title: 'Notre mission',
    description:
        'Notre mission est de contribuer au développement des infrastructures de la République Démocratique du Congo en offrant des services de construction et de métallurgie de la plus haute qualité. Nous nous engageons à réaliser chaque projet avec intégrité, dans le respect des normes internationales, des délais convenus et des budgets établis.',
    image: 'https://placehold.co/800x600/1a3a5c/ffffff?text=Notre+Mission',
    callout: 'Contribuer au développement durable des infrastructures congolaises avec excellence et intégrité.',
}

export const ABOUT_VISION: MissionVision = {
    title: 'Notre vision',
    description:
        'Devenir l\'entreprise de référence du secteur de la construction en RDC et en Afrique centrale, reconnue pour son expertise technique, la qualité de ses réalisations et son engagement envers le développement durable. Nous aspirons à être le partenaire privilégié des grands projets d\'infrastructure du pays.',
    image: 'https://placehold.co/800x600/d4a843/1a3a5c?text=Notre+Vision',
    callout: 'Devenir la référence congolaise de la construction en Afrique centrale.',
}

export const ABOUT_WHY_US = {
    title: 'Pourquoi nous choisir ?',
    subtitle: 'Des décennies d\'expertise au service de vos projets.',
    features: [
        {
            title: 'Expertise locale et internationale',
            description: 'Une connaissance approfondie du terrain congolais combinée aux standards internationaux.',
            icon: 'globe',
        },
        {
            title: 'Équipe hautement qualifiée',
            description: 'Ingénieurs, techniciens et ouvriers formés aux dernières techniques de construction.',
            icon: 'users',
        },
        {
            title: 'Respect des délais',
            description: 'Une gestion de projet rigoureuse qui garantit la livraison dans les temps impartis.',
            icon: 'clock',
        },
        {
            title: 'Approche personnalisée',
            description: 'Chaque projet est unique. Nous adaptons notre approche à vos besoins spécifiques.',
            icon: 'heart',
        },
    ],
}
