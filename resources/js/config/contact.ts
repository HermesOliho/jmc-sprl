import type { ContactInfo } from '@/types'

export const CONTACT_HERO = {
    title: 'Contactez-nous',
    subtitle:
        'Vous avez un projet ? Notre équipe est à votre écoute pour étudier votre demande et vous proposer une solution adaptée.',
    image: 'https://placehold.co/1920x800/1a3a5c/ffffff?text=Contactez+CCM+SARL',
}

export const CONTACT_INFO: ContactInfo = {
    responseTime: 'Nous répondons à toutes les demandes sous 48 heures ouvrées.',
    emergency:
        'Pour les interventions d\'urgence, contactez notre équipe au +243 81 234 5678 (disponible 7j/7).',
}

export const CONTACT_SUBJECTS = [
    { value: 'devis', label: 'Demande de devis' },
    { value: 'information', label: 'Demande d\'information' },
    { value: 'partenariat', label: 'Proposition de partenariat' },
    { value: 'reclamation', label: 'Réclamation' },
    { value: 'stage', label: 'Candidature (stage)' },
    { value: 'autre', label: 'Autre' },
]
