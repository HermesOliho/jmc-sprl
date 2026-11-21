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
import TeamSection from '@/Components/sections/TeamSection.vue'
import BrandIllustration from '@/Components/illustrations/BrandIllustration.vue'
import {
    ABOUT_HERO,
    ABOUT_PRESENTATION,
    ABOUT_VALUES,
    ABOUT_MISSION,
    ABOUT_VISION,
    ABOUT_WHY_US,
} from '@/config/about'
import { CTA_SECTION } from '@/config/home'
import type { TeamMember } from '@/types'

withDefaults(
    defineProps<{
        teamMembers?: TeamMember[]
    }>(),
    {
        teamMembers: () => [],
    },
)
</script>

<template>
    <PublicLayout>
        <SeoHead />

        <PageHeader
            :title="ABOUT_HERO.title"
            :subtitle="ABOUT_HERO.subtitle"
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'À propos' }]"
            illustration="organization"
        />

        <Section background="white">
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
                <div class="overflow-hidden rounded-2xl bg-[var(--color-brand-navy-dark)] p-5 shadow-lg md:p-8">
                    <BrandIllustration variant="organization" />
                    <p class="mt-2 text-center text-xs font-medium tracking-wide text-white/60">
                        Illustration conceptuelle
                    </p>
                </div>
                <div>
                    <SectionTitle :as="2" align="left" subtitle="Qui sommes-nous ?">
                        {{ ABOUT_PRESENTATION.title }}
                    </SectionTitle>
                    <div class="space-y-4 text-base leading-relaxed text-[var(--color-content-muted)]">
                        <p v-for="(paragraph, i) in ABOUT_PRESENTATION.content.split('\n\n')" :key="i">
                            {{ paragraph.trim() }}
                        </p>
                    </div>
                </div>
            </div>
        </Section>

        <ValuesGrid :values="ABOUT_VALUES" />

        <MissionSection :data="ABOUT_MISSION" />

        <MissionSection :data="ABOUT_VISION" reversed />

        <FeaturesSection :features="ABOUT_WHY_US.features" />

        <TeamSection :members="teamMembers" />

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
