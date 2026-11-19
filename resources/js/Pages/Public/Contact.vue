<script setup lang="ts">
import { onMounted } from 'vue'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import PageHeader from '@/Components/common/PageHeader.vue'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import CtaSection from '@/Components/sections/CtaSection.vue'
import ContactCard from '@/Components/sections/ContactCard.vue'
import ContactForm from '@/Components/sections/ContactForm.vue'
import GoogleMapPlaceholder from '@/Components/sections/GoogleMapPlaceholder.vue'
import FAQAccordion from '@/Components/sections/FAQAccordion.vue'
import FadeIn from '@/Components/animations/FadeIn.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { COMPANY } from '@/config/company'
import { CONTACT_HERO, CONTACT_INFO } from '@/config/contact'
import { CONTACT_FAQ } from '@/config/faq'
import { CTA_SECTION } from '@/config/home'
import { ROUTE_CONTACT } from '@/constants'

const jsonLd = {
    '@context': 'https://schema.org',
    '@type': 'ContactPage',
    name: 'Contact – CCM SARL',
    description: 'Contactez CCM SARL pour vos projets de construction et de métallurgie.',
    url: ROUTE_CONTACT,
    mainEntity: {
        '@type': 'Organization',
        name: COMPANY.legalName,
        telephone: COMPANY.phone,
        email: COMPANY.email,
        address: {
            '@type': 'PostalAddress',
            streetAddress: COMPANY.address.street,
            addressLocality: COMPANY.address.city,
            addressRegion: COMPANY.address.province,
            addressCountry: COMPANY.address.country,
        },
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
            title="Contact"
            description="Contactez CCM SARL pour vos projets de construction, métallurgie, électricité et travaux publics. Demandez un devis gratuit."
            :canonical="ROUTE_CONTACT"
        />

        <PageHeader
            :title="CONTACT_HERO.title"
            :subtitle="CONTACT_HERO.subtitle"
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'Contact' }]"
        />

        <Section background="white">
            <div class="grid gap-12 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <FadeIn>
                        <SectionTitle :as="3" align="left" subtitle="Nos coordonnées">
                            Entrons en contact
                        </SectionTitle>
                        <ContactCard />

                        <div class="mt-8 flex items-center gap-3">
                            <a
                                v-for="s in COMPANY.social"
                                :key="s.name"
                                :href="s.url"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-[var(--color-ccm-blue)] text-white transition-colors hover:bg-[var(--color-ccm-blue-light)]"
                                :aria-label="s.name"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <Icon :name="s.icon" :size="18" />
                            </a>
                        </div>
                    </FadeIn>
                </div>

                <div class="lg:col-span-3">
                    <FadeIn :delay="0.1">
                        <SectionTitle :as="3" align="left" subtitle="Par email">
                            Envoyez-nous un message
                        </SectionTitle>
                        <ContactForm />
                    </FadeIn>
                </div>
            </div>
        </Section>

        <Section background="gray">
            <SectionTitle subtitle="Nous trouver">
                Notre emplacement
            </SectionTitle>
            <GoogleMapPlaceholder />
        </Section>

        <Section background="white">
            <div class="mx-auto max-w-4xl">
                <SectionTitle subtitle="Informations utiles">
                    Avant de nous contacter
                </SectionTitle>
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="rounded-xl border border-[var(--color-ccm-gray-200)] bg-white p-6 text-center shadow-sm">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-ccm-blue)]/10">
                            <Icon name="clock" :size="22" class="text-[var(--color-ccm-blue)]" />
                        </div>
                        <h3 class="font-semibold text-[var(--color-ccm-gray-900)]">Délai de réponse</h3>
                        <p class="mt-2 text-sm text-[var(--color-ccm-gray-600)]">
                            {{ CONTACT_INFO.responseTime }}
                        </p>
                    </div>
                    <div class="rounded-xl border border-[var(--color-ccm-gray-200)] bg-white p-6 text-center shadow-sm">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-ccm-blue)]/10">
                            <Icon name="calendar" :size="22" class="text-[var(--color-ccm-blue)]" />
                        </div>
                        <h3 class="font-semibold text-[var(--color-ccm-gray-900)]">Disponibilité</h3>
                        <p class="mt-2 text-sm text-[var(--color-ccm-gray-600)]">
                            {{ COMPANY.hours }}
                        </p>
                    </div>
                    <div class="rounded-xl border border-[var(--color-ccm-gray-200)] bg-white p-6 text-center shadow-sm">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-ccm-blue)]/10">
                            <Icon name="phone" :size="22" class="text-[var(--color-ccm-blue)]" />
                        </div>
                        <h3 class="font-semibold text-[var(--color-ccm-gray-900)]">Urgence</h3>
                        <p class="mt-2 text-sm text-[var(--color-ccm-gray-600)]">
                            {{ CONTACT_INFO.emergency }}
                        </p>
                    </div>
                </div>
            </div>
        </Section>

        <Section background="gray">
            <SectionTitle subtitle="Questions fréquentes">
                FAQ – Contact
            </SectionTitle>
            <FAQAccordion :items="CONTACT_FAQ" />
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
