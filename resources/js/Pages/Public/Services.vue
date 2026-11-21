<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import PageHeader from '@/Components/common/PageHeader.vue'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import ServiceCard from '@/Components/sections/ServiceCard.vue'
import ProcessSection from '@/Components/sections/ProcessSection.vue'
import CtaSection from '@/Components/sections/CtaSection.vue'
import FAQAccordion from '@/Components/sections/FAQAccordion.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { SERVICES_HERO, SERVICES_PROCESS, SERVICES_FAQ } from '@/config/services'
import { CTA_SECTION } from '@/config/home'
import type { ServiceDetail } from '@/types'

defineProps<{
    services: ServiceDetail[]
}>()

const differentiators = [
    { icon: 'search', title: 'Écoute du besoin', desc: 'Une compréhension claire de votre demande avant toute proposition.' },
    { icon: 'users', title: 'Coordination', desc: 'Des responsabilités et des étapes identifiées tout au long du projet.' },
    { icon: 'clock', title: 'Planification', desc: 'Un calendrier réaliste, discuté avec vous avant le démarrage.' },
    { icon: 'shield-check', title: 'Sécurité', desc: 'Des dispositions adaptées à la nature et à l’environnement du projet.' },
    { icon: 'heart', title: 'Accompagnement', desc: 'Un interlocuteur identifiable et des échanges réguliers.' },
    { icon: 'circle-check', title: 'Qualité', desc: 'Une attention portée à la préparation, à l’exécution et aux finitions.' },
]
</script>

<template>
    <PublicLayout>
        <SeoHead />

        <PageHeader
            :title="SERVICES_HERO.title"
            :subtitle="SERVICES_HERO.subtitle"
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'Services' }]"
            illustration="construction"
        />

        <Section background="gray" id="liste">
            <SectionTitle subtitle="Notre expertise à votre service" />

            <Stagger v-if="services.length > 0" :stagger="0.06" :delay="0.1">
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="service in services"
                        :id="service.slug"
                        :key="service.slug"
                        class="scroll-mt-28"
                    >
                        <ServiceCard :service="service" />
                    </div>
                </div>
            </Stagger>

            <p v-else class="mx-auto max-w-2xl text-center text-[var(--color-content-muted)]">
                Les services seront publiés prochainement. Utilisez le formulaire de contact pour nous présenter votre besoin.
            </p>
        </Section>

        <Section background="white">
            <SectionTitle subtitle="Ce qui guide notre travail">
                Notre approche
            </SectionTitle>

            <div class="mx-auto grid max-w-5xl gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="item in differentiators"
                    :key="item.title"
                    class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm"
                >
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[var(--color-action)]/10">
                        <Icon :name="item.icon" :size="20" class="text-[var(--color-link)]" />
                    </div>
                    <h3 class="font-semibold text-[var(--color-content)]">{{ item.title }}</h3>
                    <p class="mt-1 text-sm text-[var(--color-content-muted)]">{{ item.desc }}</p>
                </div>
            </div>
        </Section>

        <ProcessSection :steps="SERVICES_PROCESS" />

        <Section background="gray">
            <SectionTitle subtitle="Questions fréquentes">
                FAQ – Services
            </SectionTitle>
            <FAQAccordion :items="SERVICES_FAQ" />
        </Section>

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
