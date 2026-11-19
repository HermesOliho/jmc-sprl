export interface NavigationItem {
    label: string
    href: string
    children?: NavigationItem[]
    external?: boolean
}

export interface SocialLink {
    name: string
    url: string
    icon: string
}

export interface CompanyInfo {
    name: string
    legalName: string
    slogan: string
    description: string
    address: Address
    phone: string
    email: string
    hours: string
    gps: GpsCoordinates
    social: SocialLink[]
}

export interface Address {
    street: string
    city: string
    province: string
    country: string
    postalCode: string
}

export interface GpsCoordinates {
    lat: number
    lng: number
}

export interface ServiceItem {
    title: string
    description: string
    icon: string
}

export interface StatsData {
    label: string
    value: string
    icon: string
}

export interface TeamMember {
    name: string
    role: string
    description?: string
    avatar?: string
    social?: SocialLink[]
}

export interface MetaInfo {
    title: string
    description: string
    canonical?: string
    ogImage?: string
    ogType?: string
    twitterCard?: string
}

export interface BreadcrumbItem {
    label: string
    href?: string
}

export type ButtonVariant = 'primary' | 'secondary' | 'outline' | 'ghost' | 'danger'
export type ButtonSize = 'sm' | 'md' | 'lg'

export type AlertType = 'success' | 'warning' | 'error' | 'info'

export type BadgeVariant = 'default' | 'primary' | 'secondary' | 'success' | 'warning' | 'error' | 'info'

export type HeadingLevel = 1 | 2 | 3 | 4

export type ContainerWidth = 'default' | 'narrow' | 'wide' | 'full'

export interface HomeHero {
    title: string
    subtitle: string
    badge: string
    stats: { label: string; value: string }[]
    primaryCta: { label: string; href: string }
    secondaryCta: { label: string; href: string }
}

export interface ValueItem {
    title: string
    description: string
    icon: string
}

export interface AboutPreview {
    title: string
    content: string
    image: string
    values: ValueItem[]
    cta: { label: string; href: string }
}

export interface Feature {
    title: string
    description: string
    icon: string
}

export interface Project {
    id: number
    title: string
    category: string
    city: string
    image: string
}

export interface Statistic {
    label: string
    value: number
    suffix: string
    icon: string
}

export interface ProcessStep {
    step: number
    title: string
    description: string
    icon: string
}

export interface Partner {
    name: string
    logo: string
}

export interface NewsArticle {
    id: number
    title: string
    date: string
    summary: string
    image: string
    category: string
}

export interface TimelineItem {
    step: number
    title: string
    description: string
    icon: string
}

export interface HistoryItem {
    year: string
    title: string
    description: string
    icon: string
}

export interface ServiceDetail extends ServiceItem {
    slug: string
    image: string
    deliverables: string[]
    benefits: string[]
}

export interface CompanyValue {
    title: string
    description: string
    icon: string
}

export interface MissionVision {
    title: string
    description: string
    image: string
    callout?: string
}

export interface Certification {
    name: string
    description: string
    logo: string
}

export interface FaqItem {
    question: string
    answer: string
}

export interface ContactFormData {
    name: string
    company: string
    email: string
    phone: string
    subject: string
    message: string
    consent: boolean
}

export interface ContactInfo {
    responseTime: string
    emergency: string
}
