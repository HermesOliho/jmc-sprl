<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import PageHeader from '@/Components/common/PageHeader.vue'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import CtaSection from '@/Components/sections/CtaSection.vue'
import ValuesGrid from '@/Components/sections/ValuesGrid.vue'
import MissionSection from '@/Components/sections/MissionSection.vue'
import FeaturesSection from '@/Components/sections/FeaturesSection.vue'
import {
    ABOUT_HERO,
    ABOUT_PRESENTATION,
    ABOUT_VALUES,
    ABOUT_MISSION,
    ABOUT_VISION,
    ABOUT_WHY_US,
} from '@/config/about'
import { CTA_SECTION } from '@/config/home'
</script>

<template>
    <PublicLayout>
        <SeoHead />

        <PageHeader
            :title="ABOUT_HERO.title"
            :subtitle="ABOUT_HERO.subtitle"
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'À propos' }]"
        />

        <Section background="white">
            <div class="mx-auto max-w-3xl">
                <SectionTitle :as="2" align="left" subtitle="Qui sommes-nous ?">
                    {{ ABOUT_PRESENTATION.title }}
                </SectionTitle>
                <div class="space-y-4 text-base leading-relaxed text-[var(--color-content-muted)]">
                    <p v-for="(paragraph, i) in ABOUT_PRESENTATION.content.split('\n\n')" :key="i">
                        {{ paragraph.trim() }}
                    </p>
                </div>
            </div>
        </Section>

        <ValuesGrid :values="ABOUT_VALUES" />

        <MissionSection :data="ABOUT_MISSION" />

        <MissionSection :data="ABOUT_VISION" reversed />

        <FeaturesSection :features="ABOUT_WHY_US.features" />

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
