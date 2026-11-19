<script setup lang="ts">
import { onMounted } from 'vue'
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
import { ALL_SERVICES, SERVICES_HERO, SERVICES_PROCESS, SERVICES_FAQ } from '@/config/services'
import { CTA_SECTION } from '@/config/home'
import { COMPANY } from '@/config/company'
import { ROUTE_SERVICES } from '@/constants'

const jsonLd = {
    '@context': 'https://schema.org',
    '@type': 'CollectionPage',
    name: 'Nos services',
    description: 'Découvrez tous les services de construction et de métallurgie de CCM SARL.',
    url: ROUTE_SERVICES,
    mainEntity: {
        '@type': 'ItemList',
        itemListElement: ALL_SERVICES.map((s, i) => ({
            '@type': 'ListItem',
            position: i + 1,
            item: {
                '@type': 'Service',
                name: s.title,
                description: s.description,
            },
        })),
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
            title="Services"
            :description="`Découvrez tous les services de ${COMPANY.name} : construction générale, métallique, électricité, travaux publics et plus.`"
            :canonical="ROUTE_SERVICES"
        />

        <PageHeader
            :title="SERVICES_HERO.title"
            :subtitle="SERVICES_HERO.subtitle"
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'Services' }]"
        />

        <Section background="gray" id="liste">
            <SectionTitle subtitle="Notre expertise à votre service" />

            <Stagger :stagger="0.06" :delay="0.1">
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <ServiceCard
                        v-for="service in ALL_SERVICES"
                        :key="service.slug"
                        :service="service"
                    />
                </div>
            </Stagger>
        </Section>

        <Section background="white">
            <SectionTitle subtitle="Ce qui fait notre différence">
                Pourquoi choisir nos services ?
            </SectionTitle>

            <div class="mx-auto grid max-w-5xl gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="item in [
                        { icon: 'award', title: 'Expertise reconnue', desc: 'Des années d\'expérience et des centaines de projets réussis.' },
                        { icon: 'users', title: 'Équipe qualifiée', desc: 'Des professionnels formés aux dernières normes et techniques.' },
                        { icon: 'clock', title: 'Respect des délais', desc: 'Un engagement ferme sur le planning de vos projets.' },
                        { icon: 'shield-check', title: 'Sécurité garantie', desc: 'Des chantiers organisés selon les normes les plus strictes.' },
                        { icon: 'heart', title: 'Accompagnement', desc: 'Un suivi personnalisé à chaque étape du projet.' },
                        { icon: 'circle-check', title: 'Qualité assurée', desc: 'Des finitions soignées et des matériaux sélectionnés.' },
                    ]"
                    :key="item.title"
                    class="rounded-xl border border-[var(--color-ccm-gray-200)] bg-white p-5 shadow-sm"
                >
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-[var(--color-ccm-blue)]/10">
                        <Icon :name="item.icon" :size="20" class="text-[var(--color-ccm-blue)]" />
                    </div>
                    <h3 class="font-semibold text-[var(--color-ccm-gray-900)]">{{ item.title }}</h3>
                    <p class="mt-1 text-sm text-[var(--color-ccm-gray-600)]">{{ item.desc }}</p>
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
