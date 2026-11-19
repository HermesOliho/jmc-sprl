import type { NavigationItem } from '@/types'

export const NAVIGATION: NavigationItem[] = [
    { label: 'Accueil', href: '/' },
    { label: 'À propos', href: '/a-propos' },
    { label: 'Services', href: '/services' },
    { label: 'Réalisations', href: '/realisations' },
    { label: 'Carrières', href: '/carrieres' },
    { label: 'Contact', href: '/contact' },
]

export const FOOTER_QUICK_LINKS: NavigationItem[] = [
    { label: 'Accueil', href: '/' },
    { label: 'À propos', href: '/a-propos' },
    { label: 'Services', href: '/services' },
    { label: 'Réalisations', href: '/realisations' },
    { label: 'Contact', href: '/contact' },
]

export const FOOTER_SERVICES: NavigationItem[] = [
    { label: 'Construction Métallique', href: '/services#metallique' },
    { label: 'Génie Civil', href: '/services#genie-civil' },
    { label: 'Infrastructures', href: '/services#infrastructures' },
    { label: 'Menuiserie Métallique', href: '/services#menuiserie' },
]
