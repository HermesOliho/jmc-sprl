<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import PageHeader from '@/Components/common/PageHeader.vue'
import Section from '@/Components/sections/Section.vue'
import AlbumCard from '@/Components/sections/AlbumCard.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import EmptyState from '@/Components/ui/feedback/EmptyState.vue'
import PrimaryButton from '@/Components/ui/buttons/PrimaryButton.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import type { Album, Paginated } from '@/types'

defineProps<{
    albums: Paginated<Album>
}>()
</script>

<template>
    <PublicLayout>
        <SeoHead />

        <PageHeader
            title="Album photo"
            subtitle="Découvrez en images nos chantiers, réalisations et temps forts à Durba et dans le Haut-Uélé."
            :breadcrumbs="[{ label: 'Accueil', href: '/' }, { label: 'Album' }]"
        />

        <Section background="gray" id="albums">
            <div v-if="albums.data.length > 0">
                <Stagger :stagger="0.06" :delay="0.1">
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <AlbumCard
                            v-for="album in albums.data"
                            :key="album.slug"
                            :album="album"
                        />
                    </div>
                </Stagger>

                <nav
                    v-if="albums.last_page > 1"
                    class="mt-12 flex flex-wrap items-center justify-center gap-4"
                    aria-label="Pagination des albums"
                >
                    <Link
                        v-if="albums.prev_page_url"
                        :href="albums.prev_page_url"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-[var(--color-border-strong)] bg-[var(--color-surface)] px-4 py-2 text-sm font-medium text-[var(--color-content)] transition hover:border-[var(--color-action)] hover:text-[var(--color-link)]"
                    >
                        <Icon name="chevron-left" :size="16" />
                        Précédent
                    </Link>

                    <span class="text-sm text-[var(--color-content-muted)]">
                        Page {{ albums.current_page }} sur {{ albums.last_page }}
                    </span>

                    <Link
                        v-if="albums.next_page_url"
                        :href="albums.next_page_url"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-[var(--color-border-strong)] bg-[var(--color-surface)] px-4 py-2 text-sm font-medium text-[var(--color-content)] transition hover:border-[var(--color-action)] hover:text-[var(--color-link)]"
                    >
                        Suivant
                        <Icon name="chevron-right" :size="16" />
                    </Link>
                </nav>
            </div>

            <EmptyState
                v-else
                icon="images"
                title="Les albums photo arrivent bientôt"
                description="Nos photos de chantiers et de réalisations seront publiées prochainement. En attendant, découvrez nos services ou contactez-nous."
            >
                <Link href="/contact">
                    <PrimaryButton>
                        Nous contacter
                        <Icon name="arrow-right" :size="18" />
                    </PrimaryButton>
                </Link>
            </EmptyState>
        </Section>
    </PublicLayout>
</template>
