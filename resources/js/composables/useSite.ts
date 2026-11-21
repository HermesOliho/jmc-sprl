import { usePage } from '@inertiajs/vue3'
import type { SiteInfo } from '@/types'

const fallback: SiteInfo = {
    name: 'JMC Services S.P.R.L',
    short_name: 'JMC Services',
    legal_name: 'JMC Services S.P.R.L',
    tagline: 'Construction, infrastructures et services',
    slogan: 'Building Progress, Moving Possibilities, Delivering Excellence',
    description: 'JMC Services S.P.R.L — construction, infrastructures et services.',
    url: '',
    locale: 'fr_CD',
    logo: '/logo.svg',
    logo_dark: '/logo_for_dark_bg.png',
    og_image: '/og/jmc-default.jpg',
    contact: {
        address: {
            street: '',
            city: 'Durba',
            province: 'Haut-Uélé',
            country: 'République Démocratique du Congo',
            postalCode: '',
        },
        phones: [
            { label: 'Congo', display: '+243 992 863 895', e164: '+243992863895', area: 'CD' },
            { label: 'Congo fixe', display: '+243 862 386 714', e164: '+243862386714', area: 'CD' },
            { label: 'Ouganda', display: '+256 708 752 780', e164: '+256708752780', area: 'UG' },
        ],
        whatsapp: {
            label: 'WhatsApp',
            display: '+243 980 637 512',
            e164: '+243980637512',
            url: 'https://wa.me/243980637512',
        },
        email: 'contact@jmcservices.com',
        website: 'https://www.jmcservices.com',
        hours: '',
        gps: null,
    },
    social: [],
    contact_subjects: [
        { value: 'devis', label: 'Demande de devis' },
        { value: 'information', label: "Demande d'information" },
        { value: 'partenariat', label: 'Proposition de partenariat' },
        { value: 'reclamation', label: 'Réclamation' },
        { value: 'stage', label: 'Candidature (stage)' },
        { value: 'autre', label: 'Autre' },
    ],
}

export function useSite(): SiteInfo {
    const page = usePage()

    return (page.props.site as SiteInfo | undefined) ?? fallback
}
