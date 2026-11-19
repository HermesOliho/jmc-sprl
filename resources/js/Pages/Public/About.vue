<script setup lang="ts">
import { onMounted } from 'vue'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import PageHeader from '@/Components/common/PageHeader.vue'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import CtaSection from '@/Components/sections/CtaSection.vue'
import CompanyHistory from '@/Components/sections/CompanyHistory.vue'
import ValuesGrid from '@/Components/sections/ValuesGrid.vue'
import MissionSection from '@/Components/sections/MissionSection.vue'
import TeamSection from '@/Components/sections/TeamSection.vue'
import CertificationGrid from '@/Components/sections/CertificationGrid.vue'
import FeaturesSection from '@/Components/sections/FeaturesSection.vue'
import FadeIn from '@/Components/animations/FadeIn.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import {
    ABOUT_HERO,
    ABOUT_PRESENTATION,
    ABOUT_HISTORY,
    ABOUT_VALUES,
    ABOUT_MISSION,
    ABOUT_VISION,
    ABOUT_WHY_US,
} from '@/config/about'
import { COMPANY } from '@/config/company'
import { TEAM_MEMBERS } from '@/config/team'
import { CERTIFICATIONS } from '@/config/certifications'
import { CTA_SECTION } from '@/config/home'
import { ROUTE_ABOUT } from '@/constants'

const jsonLd = {
    '@context': 'https://schema.org',
    '@type': 'AboutPage',
    name: 'À propos de CCM SARL',
    description: COMPANY.description,
    url: ROUTE_ABOUT,
    mainEntity: {
        '@type': 'Organization',
        name: COMPANY.legalName,
    },
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
            title="À propos"
            :description="COMPANY.description"
            :canonical="ROUTE_ABOUT"
        />

        <PageHeader
            :title="ABOUT_HERO.title"
            :subtitle="ABOUT_HERO.subtitle"
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'À propos' }]"
        />

        <Section background="white">
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
                <FadeIn>
                    <div class="relative">
                        <img
                            :src="ABOUT_HERO.image"
                            :alt="ABOUT_HERO.title"
                            class="w-full rounded-2xl object-cover shadow-lg"
                            width="960"
                            height="600"
                            loading="lazy"
                        />
                    </div>
                </FadeIn>

                <div>
                    <SectionTitle :as="2" align="left" subtitle="Qui sommes-nous ?">
                        {{ ABOUT_PRESENTATION.title }}
                    </SectionTitle>
                    <div class="space-y-4 text-base leading-relaxed text-[var(--color-ccm-gray-600)]">
                        <p v-for="(paragraph, i) in ABOUT_PRESENTATION.content.split('\n\n')" :key="i">
                            {{ paragraph.trim() }}
                        </p>
                    </div>
                </div>
            </div>
        </Section>

        <CompanyHistory :items="ABOUT_HISTORY" />

        <ValuesGrid :values="ABOUT_VALUES" />

        <MissionSection :data="ABOUT_MISSION" />

        <MissionSection :data="ABOUT_VISION" reversed />

        <TeamSection :members="TEAM_MEMBERS" />

        <CertificationGrid :certifications="CERTIFICATIONS" />

        <FeaturesSection
            :features="ABOUT_WHY_US.features"
            image="https://placehold.co/800x900/d4a843/1a3a5c?text=Pourquoi+nous+choisir"
        />

        <CtaSection
            :title="CTA_SECTION.title"
            :description="CTA_SECTION.description"
            :button-label="CTA_SECTION.primaryButton.label"
            :button-href="CTA_SECTION.primaryButton.href"
            :secondary-button-label="CTA_SECTION.secondaryButton.label"
            :secondary-button-href="CTA_SECTION.secondaryButton.href"
        />
    </PublicLayout>
</template>
