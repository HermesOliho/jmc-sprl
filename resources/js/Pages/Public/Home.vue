<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import HeroBanner from '@/Components/sections/HeroBanner.vue'
import AboutPreviewSection from '@/Components/sections/AboutPreviewSection.vue'
import ServicesPreviewSection from '@/Components/sections/ServicesPreviewSection.vue'
import LatestPhotosCarousel from '@/Components/sections/LatestPhotosCarousel.vue'
import FeaturesSection from '@/Components/sections/FeaturesSection.vue'
import ProcessSection from '@/Components/sections/ProcessSection.vue'
import PartnersCarousel from '@/Components/sections/PartnersCarousel.vue'
import CtaSection from '@/Components/sections/CtaSection.vue'
import { HOME_HERO, ABOUT_PREVIEW, FEATURES, PROCESS, CTA_SECTION } from '@/config/home'
import type { LatestAlbumPhoto, Partner, ServiceDetail } from '@/types'

withDefaults(
    defineProps<{
        partners?: Partner[]
        services?: ServiceDetail[]
        latestPhotos?: LatestAlbumPhoto[]
    }>(),
    {
        partners: () => [],
        services: () => [],
        latestPhotos: () => [],
    },
)
</script>

<template>
    <PublicLayout>
        <SeoHead />

        <nav aria-label="Fil d'Ariane" class="sr-only">
            <ol>
                <li><a href="/">Accueil</a></li>
            </ol>
        </nav>

        <HeroBanner :data="HOME_HERO" />

        <AboutPreviewSection :data="ABOUT_PREVIEW" />

        <ServicesPreviewSection :services="services" />

        <LatestPhotosCarousel :photos="latestPhotos" />

        <FeaturesSection :features="FEATURES" />

        <ProcessSection :steps="PROCESS" />

        <PartnersCarousel :partners="partners" />

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
