import type { HistoryItem, CompanyValue, MissionVision } from '@/types'

export const ABOUT_HERO = {
    title: 'À propos de JMC Services S.P.R.L',
    subtitle:
        'Une entreprise de services engagée dans la construction, les infrastructures et l’accompagnement de projets en République Démocratique du Congo.',
}

export const ABOUT_PRESENTATION = {
    title: 'Une entreprise de services engagée',
    content: `JMC Services S.P.R.L est une entreprise de services implantée à Durba, dans la province du Haut-Uélé, en République Démocratique du Congo. Elle intervient dans les domaines de la construction, des infrastructures et des services associés.

Notre organisation s’appuie sur l’écoute du besoin, la planification et la coordination des intervenants. Nous attachons une importance particulière à la qualité d’exécution et au respect des engagements convenus avec nos clients.

Cette page présente notre approche et les principes qui guident notre travail au quotidien.`,
}

export const ABOUT_HISTORY: HistoryItem[] = []

export const ABOUT_VALUES: CompanyValue[] = [
    {
        title: 'Qualité',
        description:
            'Nous portons une attention particulière à la préparation, à l’exécution et aux finitions de chaque projet.',
        icon: 'star',
    },
    {
        title: 'Sécurité',
        description:
            'La sécurité des équipes et des intervenants est intégrée dès la préparation du projet.',
        icon: 'shield-check',
    },
    {
        title: 'Professionnalisme',
        description:
            'Rigueur, transparence et respect des engagements guident notre relation avec les clients et partenaires.',
        icon: 'briefcase',
    },
    {
        title: 'Engagement',
        description:
            'Nous nous impliquons dans chaque projet avec une volonté de suivi et de continuité.',
        icon: 'heart',
    },
    {
        title: 'Respect',
        description:
            'Nous tenons compte des délais, de l’environnement du projet et des personnes concernées.',
        icon: 'users',
    },
    {
        title: 'Amélioration continue',
        description:
            'Nous tirons les enseignements de chaque expérience pour améliorer nos pratiques.',
        icon: 'trending-up',
    },
]

export const ABOUT_MISSION: MissionVision = {
    title: 'Notre engagement',
    description:
        'Mettre l’écoute du besoin, la qualité d’exécution et le respect des engagements au cœur de chaque projet, en adaptant notre organisation aux réalités du terrain.',
    callout: 'Construire une relation de confiance durable avec nos clients et partenaires.',
}

export const ABOUT_VISION: MissionVision = {
    title: 'Notre approche',
    description:
        'Travailler de manière structurée, en clarifiant les étapes, les responsabilités et les modalités de suivi avant le démarrage des travaux.',
    callout: 'Une organisation lisible, des échanges réguliers et des décisions documentées.',
}

export const ABOUT_WHY_US = {
    title: 'Pourquoi nous choisir ?',
    subtitle: 'Une approche structurée, au plus près de votre projet.',
    features: [
        {
            title: 'Écoute et compréhension du besoin',
            description: 'Nous prenons le temps de cadrer votre demande avant de proposer une solution.',
            icon: 'search',
        },
        {
            title: 'Organisation du projet',
            description: 'Les étapes, les responsabilités et les modalités de suivi sont clarifiées.',
            icon: 'calendar',
        },
        {
            title: 'Qualité et sécurité',
            description: 'Ces exigences sont intégrées à la préparation et à l’exécution des travaux.',
            icon: 'shield-check',
        },
        {
            title: 'Communication',
            description: 'Un interlocuteur identifié et des échanges réguliers tout au long du projet.',
            icon: 'message-circle',
        },
    ],
}
