import type { HomeHero, AboutPreview, Feature, TimelineItem } from '@/types'

export const HOME_HERO: HomeHero = {
    title: 'Construire aujourd’hui les infrastructures de demain',
    subtitle:
        'JMC Services S.P.R.L accompagne les porteurs de projets dans la construction, les infrastructures et les services associés, avec une attention constante portée à la qualité et au respect des engagements.',
    badge: 'JMC Services S.P.R.L',
    stats: [],
    primaryCta: { label: 'Découvrir nos services', href: '/services' },
    secondaryCta: { label: 'Demander un devis', href: '/contact?subject=devis' },
}

export const ABOUT_PREVIEW: AboutPreview = {
    title: 'Qui sommes-nous ?',
    content:
        'JMC Services S.P.R.L est une entreprise de services implantée à Durba, dans la province du Haut-Uélé, en République Démocratique du Congo. Nous intervenons dans les domaines de la construction, des infrastructures et des services associés. Notre approche s’appuie sur l’écoute du besoin, la qualité d’exécution et le respect des engagements.',
    values: [
        {
            title: 'Qualité',
            description: 'Une attention particulière portée aux finitions et à la cohérence de chaque réalisation.',
            icon: 'star',
        },
        {
            title: 'Sécurité',
            description: 'La sécurité des équipes et des intervenants est intégrée à la préparation de chaque projet.',
            icon: 'shield-check',
        },
        {
            title: 'Engagement',
            description: 'Une relation de travail fondée sur la transparence, l’écoute et le suivi.',
            icon: 'heart',
        },
    ],
    cta: { label: 'En savoir plus', href: '/a-propos' },
}

export const FEATURES: Feature[] = [
    {
        title: 'Écoute du besoin',
        description: 'Chaque projet commence par une compréhension claire de vos attentes et de vos contraintes.',
        icon: 'search',
    },
    {
        title: 'Qualité d’exécution',
        description: 'Une organisation rigoureuse et une attention portée aux détails à chaque étape.',
        icon: 'award',
    },
    {
        title: 'Respect des délais',
        description: 'Une planification réaliste et un suivi régulier pour tenir les engagements convenus.',
        icon: 'clock',
    },
    {
        title: 'Sécurité',
        description: 'Des dispositions adaptées à la nature du projet et à son environnement.',
        icon: 'shield-check',
    },
    {
        title: 'Accompagnement',
        description: 'Un interlocuteur identifiable et une communication continue tout au long du projet.',
        icon: 'heart',
    },
    {
        title: 'Amélioration continue',
        description: 'Une démarche d’apprentissage et d’ajustement au fil des projets.',
        icon: 'trending-up',
    },
]

export const PROCESS: TimelineItem[] = [
    {
        step: 1,
        title: 'Analyse',
        description: 'Rencontre et étude de vos besoins, contraintes et priorités.',
        icon: 'search',
    },
    {
        step: 2,
        title: 'Étude',
        description: 'Conception technique et élaboration du cahier des charges.',
        icon: 'file-text',
    },
    {
        step: 3,
        title: 'Planification',
        description: 'Organisation des étapes, des ressources et du calendrier.',
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

export const CTA_SECTION = {
    title: 'Parlons de votre projet',
    description:
        'Présentez-nous votre besoin : nous vous répondrons avec une première orientation et les informations utiles pour la suite.',
    primaryButton: { label: 'Demander un devis', href: '/contact?subject=devis' },
    secondaryButton: { label: 'Nous contacter', href: '/contact' },
}
