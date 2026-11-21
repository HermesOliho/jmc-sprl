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
            title="Politique de confidentialité"
            subtitle="Comment les données transmises via le formulaire de contact sont utilisées."
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'Confidentialité' }]"
        />

        <Section background="white">
            <div class="mx-auto max-w-3xl space-y-10 text-[var(--color-content-muted)]">
                <div>
                    <SectionTitle :as="2" align="left">Responsable du traitement</SectionTitle>
                    <p class="mt-4">
                        Les données transmises via le formulaire de contact sont traitées par
                        <strong class="text-[var(--color-content)]">{{ site.legal_name }}</strong>.
                    </p>
                    <p class="mt-2">
                        Pour toute question relative à vos données, vous pouvez écrire à
                        <a
                            :href="`mailto:${site.contact.email}`"
                            class="font-medium text-[var(--color-link)] underline-offset-2 hover:underline"
                        >
                            {{ site.contact.email }}
                        </a>
                        ou par courrier à {{ formatAddress(site.contact.address) }}.
                    </p>
                    <p class="mt-2 italic">
                        La base légale du traitement reste à valider par la direction et le service juridique.
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Données collectées</SectionTitle>
                    <p class="mt-4">
                        Le formulaire de contact permet de transmettre votre nom, votre entreprise, votre adresse e-mail,
                        votre téléphone, le sujet de votre demande et votre message.
                    </p>
                    <p class="mt-2">
                        Aucun autre champ n’est collecté par le formulaire. Le site n’utilise pas d’outil de mesure d’audience
                        à ce stade.
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Finalité et utilisation</SectionTitle>
                    <p class="mt-4">
                        Ces données sont utilisées uniquement pour répondre à votre demande et, le cas échéant,
                        pour poursuivre les échanges nécessaires au traitement de votre projet.
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Durée de conservation</SectionTitle>
                    <p class="mt-4 italic">
                        Durée à définir et à valider par la direction et le service juridique.
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Destinataires</SectionTitle>
                    <p class="mt-4">
                        Les données sont destinées aux personnes chargées du traitement des demandes au sein de
                        {{ site.name }}. Elles ne sont pas cédées à des tiers à des fins commerciales.
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Vos droits</SectionTitle>
                    <p class="mt-4">
                        Vous pouvez demander l’accès, la rectification ou la suppression des données vous concernant
                        en utilisant le formulaire de contact ou en écrivant à
                        <a
                            :href="`mailto:${site.contact.email}`"
                            class="font-medium text-[var(--color-link)] underline-offset-2 hover:underline"
                        >
                            {{ site.contact.email }}
                        </a>.
                    </p>
                </div>

                <div>
                    <SectionTitle :as="2" align="left">Cookies</SectionTitle>
                    <p class="mt-4">
                        Le site utilise uniquement les cookies techniques nécessaires à son fonctionnement
                        (session et sécurité). Aucun cookie publicitaire ou de mesure d’audience n’est installé à ce stade.
                    </p>
                </div>

                <div class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-5 text-sm">
                    <p>
                        <strong class="text-[var(--color-content)]">Information de validation :</strong>
                        cette politique doit être relue et complétée avec les informations légales définitives
                        (base légale, durée de conservation, hébergeur) avant la mise en production.
                    </p>
                </div>
            </div>
        </Section>
    </PublicLayout>
</template>
