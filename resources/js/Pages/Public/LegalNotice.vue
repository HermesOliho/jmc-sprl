<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import PageHeader from '@/Components/common/PageHeader.vue'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import { useSite } from '@/composables'
import { formatAddress } from '@/utils'

const site = useSite()
</script>

<template>
    <PublicLayout>
        <SeoHead />

        <PageHeader
            title="Mentions légales"
            subtitle="Informations relatives à l’éditeur et au fonctionnement du site."
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'Mentions légales' }]"
        />

        <Section background="white">
            <div class="mx-auto max-w-3xl space-y-10 text-[var(--color-content-muted)]">
                <div>
                    <SectionTitle :as="2" align="left">Éditeur du site</SectionTitle>
                    <p class="mt-4">
                        Le présent site est édité par <strong class="text-[var(--color-content)]">{{ site.legal_name }}</strong>.
                    </p>
                    <p class="mt-2">
                        Adresse du siège : {{ formatAddress(site.contact.address) }}.
                    </p>
                    <p v-if="site.contact.phones.length > 0" class="mt-2">
                        Téléphone :
                        <template v-for="(phone, index) in site.contact.phones" :key="phone.e164">
                            <a
                                :href="`tel:${phone.e164}`"
                                class="font-medium text-[var(--color-link)] underline-offset-2 hover:underline"
                            >
                                {{ phone.display }}
                            </a><span v-if="index < site.contact.phones.length - 1">, </span>
                        </template>
                    </p>
                    <p v-if="site.contact.whatsapp" class="mt-2">
                        WhatsApp :
                        <a
                            :href="site.contact.whatsapp.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="font-medium text-[var(--color-link)] underline-offset-2 hover:underline"
                        >
                            {{ site.contact.whatsapp.display }}
                        </a>
                    </p>
                    <p v-if="site.contact.email" class="mt-2">
                        E-mail :
                        <a
                            :href="`mailto:${site.contact.email}`"
                            class="font-medium text-[var(--color-link)] underline-offset-2 hover:underline"
                        >
                            {{ site.contact.email }}
                        </a>
                    </p>
                    <p v-if="site.contact.website" class="mt-2">
                        Site web :
                        <a
                            :href="site.contact.website"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="font-medium text-[var(--color-link)] underline-offset-2 hover:underline"
                        >
                            {{ site.contact.website.replace(/^https?:\/\//, '').replace(/\/$/, '') }}
                        </a>
                    </p>
                    <p class="mt-2">
                        Immatriculation / identification légale : <span class="italic">à compléter (registre du commerce, identifiant national, etc.).</span>
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Responsable de la publication</SectionTitle>
                    <p class="mt-4 italic">
                        Nom et fonction à compléter et à valider par la direction.
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Hébergement</SectionTitle>
                    <p class="mt-4 italic">
                        Nom, adresse et coordonnées de l’hébergeur à compléter.
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Propriété intellectuelle</SectionTitle>
                    <p class="mt-4">
                        Les contenus, textes, visuels et éléments graphiques présents sur ce site sont protégés.
                        Toute reproduction ou utilisation sans autorisation préalable est interdite.
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Contact</SectionTitle>
                    <p class="mt-4">
                        Pour toute question relative au site, utilisez le
                        <a href="/contact" class="font-medium text-[var(--color-link)] underline-offset-2 hover:underline">formulaire de contact</a>
                        ou écrivez à
                        <a
                            :href="`mailto:${site.contact.email}`"
                            class="font-medium text-[var(--color-link)] underline-offset-2 hover:underline"
                        >
                            {{ site.contact.email }}
                        </a>.
                    </p>
                </div>

                <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-5 text-sm">
                    <p>
                        <strong class="text-[var(--color-content)]">Information de validation :</strong>
                        les informations légales encore manquantes (immatriculation, responsable de publication, hébergeur)
                        doivent être fournies et validées par la direction avant la mise en production.
                    </p>
                </div>
            </div>
        </Section>
    </PublicLayout>
</template>
