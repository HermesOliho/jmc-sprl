import type { CompanyInfo, ServiceItem, StatsData } from '@/types'

export const COMPANY: CompanyInfo = {
    name: 'CCM SARL',
    legalName: 'Congo Construction & Métallique SARL',
    slogan: 'Bâtir l\'avenir avec excellence et intégrité',
    description: 'Entreprise congolaise de référence dans le secteur de la construction et de la métallurgie, spécialisée dans les projets d\'infrastructure, la construction métallique et le génie civil.',
    address: {
        street: 'Avenue de la Libération, n° 15',
        city: 'Kinshasa',
        province: 'Kinshasa',
        country: 'République Démocratique du Congo',
        postalCode: '',
    },
    phone: '+243 81 234 5678',
    email: 'info@ccmsarl.cd',
    hours: 'Lun–Ven: 07:30 – 16:30 | Sam: 08:00 – 12:00',
    gps: {
        lat: -4.44193,
        lng: 15.26629,
    },
    social: [
        { name: 'Facebook', url: 'https://facebook.com/ccmsarl', icon: 'facebook' },
        { name: 'LinkedIn', url: 'https://linkedin.com/company/ccmsarl', icon: 'linkedin' },
        { name: 'WhatsApp', url: 'https://wa.me/243812345678', icon: 'phone' },
        { name: 'YouTube', url: 'https://youtube.com/@ccmsarl', icon: 'youtube' },
    ],
}

export const SERVICES: ServiceItem[] = [
    {
        title: 'Construction Métallique',
        description: 'Fabrication et montage de charpentes métalliques, sheds, hangars et structures industrielles sur mesure.',
        icon: 'building2',
    },
    {
        title: 'Génie Civil',
        description: 'Réalisation de fondations, dallages, voiries, réseaux divers et ouvrages d\'art.',
        icon: 'hardHat',
    },
    {
        title: 'Infrastructures',
        description: 'Construction et réhabilitation de routes, ponts, bâtiments publics et complexes commerciaux.',
        icon: 'landmark',
    },
    {
        title: 'Menuiserie Métallique',
        description: 'Fabrication de portes, fenêtres, garde-corps, escaliers et mobilier métallique.',
        icon: 'ruler',
    },
]

export const STATS: StatsData[] = [
    { label: 'Projets réalisés', value: '150+', icon: 'briefcase' },
    { label: 'Années d\'expérience', value: '12+', icon: 'calendar' },
    { label: 'Collaborateurs', value: '200+', icon: 'users' },
    { label: 'Clients satisfaits', value: '80+', icon: 'heart' },
]
