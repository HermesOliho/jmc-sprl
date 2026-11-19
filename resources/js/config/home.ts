import type { HomeHero, AboutPreview, Feature, TimelineItem } from '@/types'

export const HOME_HERO: HomeHero = {
    title: 'Construisons aujourd\'hui les infrastructures de demain',
    subtitle:
        'Expert en construction générale, métallique et génie civil, CCM SARL donne vie à vos projets avec rigueur, sécurité et excellence.',
    badge: 'Entreprise congolaise',
    stats: [
        { label: 'Projets réalisés', value: '20+' },
        { label: 'Années d\'expertise', value: '15+' },
        { label: 'Professionnalisme', value: '100%' },
    ],
    primaryCta: { label: 'Découvrir nos services', href: '/services' },
    secondaryCta: { label: 'Demander un devis', href: '/demande-devis' },
}

export const ABOUT_PREVIEW: AboutPreview = {
    title: 'Qui sommes-nous ?',
    content:
        'Congo Construction & Métallique SARL est une entreprise congolaise de référence dans le secteur du BTP. Spécialisée en construction générale, métallique, électricité bâtiment et travaux publics, nous accompagnons nos clients de la conception à la livraison, avec un engagement constant pour la qualité et la satisfaction.',
    image: 'https://placehold.co/800x600/1a3a5c/ffffff?text=CCM+SARL',
    values: [
        {
            title: 'Qualité',
            description: 'Des finitions soignées et des matériaux sélectionnés pour chaque projet.',
            icon: 'star',
        },
        {
            title: 'Innovation',
            description: 'Des solutions techniques modernes adaptées aux défis d\'aujourd\'hui.',
            icon: 'trending-up',
        },
        {
            title: 'Engagement',
            description: 'Une relation de confiance bâtie sur la transparence et le respect des délais.',
            icon: 'heart',
        },
    ],
    cta: { label: 'En savoir plus', href: '/a-propos' },
}

export const FEATURES: Feature[] = [
    {
        title: 'Expertise reconnue',
        description: 'Une équipe d\'ingénieurs et de techniciens qualifiés pour des réalisations d\'excellence.',
        icon: 'award',
    },
    {
        title: 'Équipe qualifiée',
        description: 'Des professionnels formés aux dernières techniques et normes de construction.',
        icon: 'users',
    },
    {
        title: 'Respect des délais',
        description: 'Une gestion de projet rigoureuse pour livrer dans les temps, sans compromis sur la qualité.',
        icon: 'clock',
    },
    {
        title: 'Sécurité avant tout',
        description: 'Des chantiers organisés selon les normes de sécurité les plus strictes.',
        icon: 'shield-check',
    },
    {
        title: 'Accompagnement sur mesure',
        description: 'Un suivi personnalisé à chaque étape, de l\'étude à la livraison finale.',
        icon: 'heart',
    },
    {
        title: 'Matériel moderne',
        description: 'Des équipements récents et performants pour une exécution précise et efficace.',
        icon: 'cog',
    },
]

export const PROCESS: TimelineItem[] = [
    {
        step: 1,
        title: 'Analyse',
        description: 'Rencontre et étude approfondie de vos besoins et contraintes.',
        icon: 'search',
    },
    {
        step: 2,
        title: 'Étude',
        description: 'Conception technique et élaboration du cahier des charges détaillé.',
        icon: 'file-text',
    },
    {
        step: 3,
        title: 'Conception',
        description: 'Plans, schémas et maquettes pour valider chaque aspect du projet.',
        icon: 'ruler',
    },
    {
        step: 4,
        title: 'Réalisation',
        description: 'Exécution chantier dans le respect des normes et du planning.',
        icon: 'hard-hat',
    },
    {
        step: 5,
        title: 'Livraison',
        description: 'Réception des travaux et accompagnement post-livraison.',
        icon: 'circle-check',
    },
]

export const CTA_SECTION = {
    title: 'Besoin d\'un partenaire fiable ?',
    description:
        'Confiez-nous vos projets de construction, rénovation ou infrastructure. Nous vous accompagnons de A à Z avec professionnalisme et dévouement.',
    primaryButton: { label: 'Demander un devis', href: '/demande-devis' },
    secondaryButton: { label: 'Téléphoner', href: 'tel:+243812345678' },
}
