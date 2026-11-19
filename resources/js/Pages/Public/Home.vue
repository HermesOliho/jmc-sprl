<script setup lang="ts">
import { onMounted } from 'vue'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import HeroBanner from '@/Components/sections/HeroBanner.vue'
import AboutPreviewSection from '@/Components/sections/AboutPreviewSection.vue'
import ServicesPreviewSection from '@/Components/sections/ServicesPreviewSection.vue'
import FeaturesSection from '@/Components/sections/FeaturesSection.vue'
import ProjectsCarousel from '@/Components/sections/ProjectsCarousel.vue'
import StatisticsSection from '@/Components/sections/StatisticsSection.vue'
import ProcessSection from '@/Components/sections/ProcessSection.vue'
import PartnersCarousel from '@/Components/sections/PartnersCarousel.vue'
import CtaSection from '@/Components/sections/CtaSection.vue'
import NewsSection from '@/Components/sections/NewsSection.vue'
import { HOME_HERO, ABOUT_PREVIEW, FEATURES, PROCESS, CTA_SECTION } from '@/config/home'
import { HOME_SERVICES } from '@/config/services'
import { HOME_STATISTICS } from '@/config/statistics'
import { HOME_PROJECTS } from '@/config/projects'
import { HOME_PARTNERS } from '@/config/partners'
import { HOME_NEWS } from '@/config/news'
import { COMPANY } from '@/config/company'
import { ROUTE_HOME } from '@/constants'

const jsonLd = {
    '@context': 'https://schema.org',
    '@type': 'Organization',
    name: COMPANY.legalName,
    alternateName: COMPANY.name,
    description: COMPANY.description,
    url: ROUTE_HOME,
    contactPoint: {
        '@type': 'ContactPoint',
        telephone: COMPANY.phone,
        contactType: 'customer service',
        areaServed: 'CD',
        availableLanguage: 'French',
    },
    address: {
        '@type': 'PostalAddress',
        streetAddress: COMPANY.address.street,
        addressLocality: COMPANY.address.city,
        addressRegion: COMPANY.address.province,
        addressCountry: COMPANY.address.country,
    },
    sameAs: COMPANY.social.filter(s => s.url.startsWith('http')).map(s => s.url),
}

onMounted(() => {
    const script = document.createElement('script')
    script.type = 'application/ld+json'
    script.textContent = JSON.stringify(jsonLd)
    document.head.appendChild(script)
})
</script>

<template>
    <PublicLayout>
        <SeoHead
            title="Accueil"
            :description="COMPANY.description"
            :canonical="ROUTE_HOME"
        />

        <nav aria-label="Fil d'Ariane" class="sr-only">
            <ol>
                <li><a href="/">Accueil</a></li>
            </ol>
        </nav>

        <HeroBanner
            :data="HOME_HERO"
            background-image="https://placehold.co/1920x1080/0f2440/0f2440?text=CCM+SARL+Construction"
        />

        <AboutPreviewSection :data="ABOUT_PREVIEW" />

        <ServicesPreviewSection :services="HOME_SERVICES" />

        <FeaturesSection
            :features="FEATURES"
            image="https://placehold.co/800x900/d4a843/1a3a5c?text=Pourquoi+CCM+SARL"
        />

        <ProjectsCarousel :projects="HOME_PROJECTS" />

        <StatisticsSection :statistics="HOME_STATISTICS" />

        <ProcessSection :steps="PROCESS" />

        <PartnersCarousel :partners="HOME_PARTNERS" />

        <CtaSection
            :title="CTA_SECTION.title"
            :description="CTA_SECTION.description"
            :button-label="CTA_SECTION.primaryButton.label"
            :button-href="CTA_SECTION.primaryButton.href"
            :secondary-button-label="CTA_SECTION.secondaryButton.label"
            :secondary-button-href="CTA_SECTION.secondaryButton.href"
        />

        <NewsSection :articles="HOME_NEWS" />
    </PublicLayout>
</template>
