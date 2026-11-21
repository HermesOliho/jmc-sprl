<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import PageHeader from '@/Components/common/PageHeader.vue'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import CtaSection from '@/Components/sections/CtaSection.vue'
import ContactCard from '@/Components/sections/ContactCard.vue'
import ContactForm from '@/Components/sections/ContactForm.vue'
import FAQAccordion from '@/Components/sections/FAQAccordion.vue'
import FadeIn from '@/Components/animations/FadeIn.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { useSite } from '@/composables'
import { formatAddress } from '@/utils'
import { CONTACT_HERO, CONTACT_INFO } from '@/config/contact'
import { CONTACT_FAQ } from '@/config/faq'
import { CTA_SECTION } from '@/config/home'

const site = useSite()

withDefaults(
    defineProps<{
        services?: Array<{ slug: string; title: string }>
    }>(),
    {
        services: () => [],
    },
)
</script>

<template>
    <PublicLayout>
        <SeoHead />

        <PageHeader
            :title="CONTACT_HERO.title"
            :subtitle="CONTACT_HERO.subtitle"
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'Contact' }]"
            illustration="location"
        />

        <Section background="white">
            <div class="grid gap-12 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <FadeIn>
                        <SectionTitle :as="2" align="left" subtitle="Nos coordonnées">
                            Entrons en contact
                        </SectionTitle>
                        <ContactCard />

                        <a
                            v-if="site.contact.whatsapp"
                            :href="site.contact.whatsapp.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-6 inline-flex items-center gap-2 rounded-lg bg-[var(--color-action)] px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[var(--color-action-hover)]"
                        >
                            <Icon name="message-circle" :size="18" />
                            Discuter sur WhatsApp
                        </a>

                        <div v-if="site.social.length > 0" class="mt-8 flex items-center gap-3">
                            <a
                                v-for="s in site.social"
                                :key="s.name"
                                :href="s.url"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-[var(--color-action)] text-white transition-colors hover:bg-[var(--color-action-hover)]"
                                :aria-label="s.name"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <Icon :name="s.icon ?? 'globe'" :size="18" />
                            </a>
                        </div>
                    </FadeIn>
                </div>

                <div class="lg:col-span-3">
                    <FadeIn :delay="0.1">
                        <SectionTitle :as="2" align="left" subtitle="Par formulaire">
                            Envoyez-nous un message
                        </SectionTitle>
                        <ContactForm :services="services" />
                        <p class="mt-4 text-sm text-[var(--color-content-muted)]">
                            En envoyant ce formulaire, vous acceptez que vos données soient utilisées pour répondre à votre demande.
                            Consultez notre
                            <Link href="/politique-de-confidentialite" class="font-medium text-[var(--color-link)] underline-offset-2 hover:underline">
                                politique de confidentialité
                            </Link>.
                        </p>
                    </FadeIn>
                </div>
            </div>
        </Section>

        <Section background="gray">
            <div class="mx-auto max-w-4xl">
                <SectionTitle subtitle="Informations utiles">
                    Avant de nous contacter
                </SectionTitle>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 text-center shadow-sm">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-action)]/10">
                            <Icon name="clock" :size="22" class="text-[var(--color-link)]" />
                        </div>
                        <h3 class="font-semibold text-[var(--color-content)]">Délai de réponse</h3>
                        <p class="mt-2 text-sm text-[var(--color-content-muted)]">
                            {{ CONTACT_INFO.responseTime }}
                        </p>
                    </div>
                    <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 text-center shadow-sm">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-action)]/10">
                            <Icon name="map-pin" :size="22" class="text-[var(--color-link)]" />
                        </div>
                        <h3 class="font-semibold text-[var(--color-content)]">Localisation</h3>
                        <p class="mt-2 text-sm text-[var(--color-content-muted)]">
                            {{ formatAddress(site.contact.address) }}
                        </p>
                    </div>
                </div>
            </div>
        </Section>

        <Section background="white">
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
