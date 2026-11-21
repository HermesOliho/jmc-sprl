import type { NavigationItem } from '@/types'

export const NAVIGATION: NavigationItem[] = [
    { label: 'Accueil', href: '/' },
    { label: 'À propos', href: '/a-propos' },
    { label: 'Services', href: '/services' },
    { label: 'Contact', href: '/contact' },
]

export const FOOTER_QUICK_LINKS: NavigationItem[] = [
    { label: 'Accueil', href: '/' },
    { label: 'À propos', href: '/a-propos' },
    { label: 'Services', href: '/services' },
    { label: 'Contact', href: '/contact' },
]

export const FOOTER_SERVICES: NavigationItem[] = [
    { label: 'Construction générale', href: '/services#construction-generale' },
    { label: 'Construction métallique', href: '/services#construction-metallique' },
    { label: 'Travaux publics', href: '/services#travaux-publics' },
    { label: 'Électricité bâtiment', href: '/services#electricite-batiment' },
]

export const FOOTER_LEGAL_LINKS: NavigationItem[] = [
    { label: 'Mentions légales', href: '/mentions-legales' },
    { label: 'Confidentialité', href: '/politique-de-confidentialite' },
]
