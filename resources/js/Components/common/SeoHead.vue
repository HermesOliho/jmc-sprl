<script setup lang="ts">
import { computed, onMounted, watch } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import { useSite } from '@/composables'

const props = withDefaults(defineProps<{
    title?: string
    description?: string
    canonical?: string
    ogImage?: string
    ogType?: string
    twitterCard?: string
}>(), {
    ogType: 'website',
    twitterCard: 'summary_large_image',
})

const page = usePage()
const site = useSite()

const seo = computed<Record<string, string>>(() => (page.props.seo as Record<string, string> | undefined) ?? {})

const pageTitle = computed(() => {
    const rawTitle = props.title ?? seo.value.title ?? site.name
    return rawTitle === site.name ? rawTitle : `${rawTitle} — ${site.name}`
})

const description = computed(() => props.description ?? seo.value.description ?? site.description)
const canonicalPath = computed(() => props.canonical ?? seo.value.path ?? page.url.split('?')[0])
const canonicalUrl = computed(() => {
    const path = canonicalPath.value

    if (path.startsWith('http://') || path.startsWith('https://')) {
        return path
    }

    return `${site.url.replace(/\/$/, '')}${path.startsWith('/') ? path : `/${path}`}`
})
const ogImage = computed(() => {
    const image = props.ogImage ?? site.og_image

    if (!image) {
        return ''
    }

    return image.startsWith('http') ? image : `${site.url.replace(/\/$/, '')}${image.startsWith('/') ? image : `/${image}`}`
})

function upsertMeta(attribute: 'name' | 'property', key: string, content: string): void {
    let element = document.head.querySelector<HTMLMetaElement>(`meta[${attribute}="${key}"]`)

    if (!element) {
        element = document.createElement('meta')
        element.setAttribute(attribute, key)
        document.head.appendChild(element)
    }

    element.setAttribute('content', content)
}

function upsertLink(rel: string, href: string): void {
    let element = document.head.querySelector<HTMLLinkElement>(`link[rel="${rel}"]`)

    if (!element) {
        element = document.createElement('link')
        element.setAttribute('rel', rel)
        document.head.appendChild(element)
    }

    element.setAttribute('href', href)
}

function jsonLd(): Record<string, unknown> {
    const organization: Record<string, unknown> = {
        '@type': 'Organization',
        '@id': `${site.url}/#organization`,
        name: site.legal_name,
        url: `${site.url}/`,
        logo: `${site.url}${site.logo}`,
        ...(site.slogan ? { slogan: site.slogan } : {}),
    }

    if (site.contact.email) {
        organization.email = site.contact.email
    }

    if (site.contact.address.city) {
        organization.address = {
            '@type': 'PostalAddress',
            ...(site.contact.address.street ? { streetAddress: site.contact.address.street } : {}),
            addressLocality: site.contact.address.city,
            addressRegion: site.contact.address.province,
            addressCountry: 'CD',
        }
    }

    const primaryPhone = site.contact.phones[0]?.e164

    if (primaryPhone) {
        organization.telephone = primaryPhone
    }

    if (site.contact.phones.length > 0) {
        organization.contactPoint = site.contact.phones.map((phone) => ({
            '@type': 'ContactPoint',
            contactType: 'customer service',
            telephone: phone.e164,
            ...(phone.area ? { areaServed: phone.area } : {}),
            availableLanguage: ['fr', 'en'],
        }))
    }

    if (site.social.length > 0) {
        organization.sameAs = site.social.map((link) => link.url)
    }

    return {
        '@context': 'https://schema.org',
        '@graph': [
            organization,
            {
                '@type': 'WebSite',
                '@id': `${site.url}/#website`,
                url: `${site.url}/`,
                name: site.name,
                inLanguage: 'fr',
                publisher: { '@id': `${site.url}/#organization` },
            },
            {
                '@type': seo.value.type ?? 'WebPage',
                '@id': `${canonicalUrl.value}#webpage`,
                url: canonicalUrl.value,
                name: pageTitle.value,
                description: description.value,
                isPartOf: { '@id': `${site.url}/#website` },
                about: { '@id': `${site.url}/#organization` },
            },
        ],
    }
}

function applySeo(): void {
    if (typeof document === 'undefined') {
        return
    }

    upsertMeta('name', 'description', description.value)
    upsertMeta('property', 'og:title', pageTitle.value)
    upsertMeta('property', 'og:description', description.value)
    upsertMeta('property', 'og:type', props.ogType)
    upsertMeta('property', 'og:url', canonicalUrl.value)
    upsertMeta('property', 'og:site_name', site.name)
    upsertMeta('property', 'og:locale', site.locale)
    upsertMeta('name', 'twitter:card', props.twitterCard)
    upsertMeta('name', 'twitter:title', pageTitle.value)
    upsertMeta('name', 'twitter:description', description.value)

    if (seo.value.robots) {
        upsertMeta('name', 'robots', seo.value.robots)
    } else {
        document.head.querySelector('meta[name="robots"]')?.remove()
    }

    if (ogImage.value) {
        upsertMeta('property', 'og:image', ogImage.value)
        upsertMeta('property', 'og:image:alt', pageTitle.value)
        upsertMeta('name', 'twitter:image', ogImage.value)
    }

    upsertLink('canonical', canonicalUrl.value)

    let script = document.head.querySelector<HTMLScriptElement>('script[data-seo-jsonld]')

    if (!script) {
        script = document.createElement('script')
        script.type = 'application/ld+json'
        script.dataset.seoJsonld = 'true'
        document.head.appendChild(script)
    }

    script.textContent = JSON.stringify(jsonLd())
}

onMounted(applySeo)
watch([pageTitle, description, canonicalUrl, ogImage, () => props.ogType, () => props.twitterCard], applySeo)
</script>

<template>
    <Head>
        <title>{{ pageTitle }}</title>
    </Head>
    <slot />
</template>
