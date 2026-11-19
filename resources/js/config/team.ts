import type { TeamMember } from '@/types'

export const TEAM_MEMBERS: TeamMember[] = [
    {
        name: 'Jean-Pierre Kabongo',
        role: 'Directeur Général',
        description:
            'Fondateur de CCM SARL, ingénieur civil avec plus de 20 ans d\'expérience dans le secteur de la construction en RDC et à l\'international.',
        avatar: 'https://placehold.co/400x400/1a3a5c/ffffff?text=JPK',
        social: [
            { name: 'LinkedIn', url: '#', icon: 'linkedin' },
            { name: 'Email', url: '#', icon: 'mail' },
        ],
    },
    {
        name: 'Marie-Claire Ntumba',
        role: 'Directrice Technique',
        description:
            'Ingénieure en génie civil, spécialisée dans la conception et la gestion de projets d\'infrastructures complexes.',
        avatar: 'https://placehold.co/400x400/d4a843/1a3a5c?text=MCN',
        social: [
            { name: 'LinkedIn', url: '#', icon: 'linkedin' },
            { name: 'Email', url: '#', icon: 'mail' },
        ],
    },
    {
        name: 'Paul Mputu',
        role: 'Responsable Construction Métallique',
        description:
            'Expert en structures métalliques avec 15 ans d\'expérience dans la fabrication et le montage d\'ouvrages métalliques.',
        avatar: 'https://placehold.co/400x400/1a3a5c/ffffff?text=PM',
        social: [
            { name: 'LinkedIn', url: '#', icon: 'linkedin' },
            { name: 'Email', url: '#', icon: 'mail' },
        ],
    },
    {
        name: 'Esther Lukusa',
        role: 'Responsable Administratif & Finances',
        description:
            'Experte en gestion financière et administrative, elle assure la bonne gestion des ressources et le suivi des projets.',
        avatar: 'https://placehold.co/400x400/d4a843/1a3a5c?text=EL',
        social: [
            { name: 'LinkedIn', url: '#', icon: 'linkedin' },
            { name: 'Email', url: '#', icon: 'mail' },
        ],
    },
]
