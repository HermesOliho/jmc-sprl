<script setup lang="ts">
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import SeoHead from '@/Components/common/SeoHead.vue'
import PageHeader from '@/Components/common/PageHeader.vue'
import Section from '@/Components/sections/Section.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import EmptyState from '@/Components/ui/feedback/EmptyState.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import PhotoLightbox from '@/Components/ui/overlays/PhotoLightbox.vue'
import { formatDate } from '@/utils'
import type { Album, AlbumPhoto, Paginated } from '@/types'

defineProps<{
    album: Album
    photos: Paginated<AlbumPhoto>
}>()

const lightboxOpen = ref(false)
const activePhotoIndex = ref(0)

function openLightbox(index: number): void {
    activePhotoIndex.value = index
    lightboxOpen.value = true
}
</script>

<template>
    <PublicLayout>
        <SeoHead :og-image="album.cover_url ?? undefined" />

        <PageHeader
            :title="album.title"
            :subtitle="album.description ?? undefined"
            :breadcrumbs="[
                { label: 'Accueil', href: '/' },
                { label: 'Album', href: '/album' },
                { label: album.title },
            ]"
            :background-image="album.cover_url ?? undefined"
        />

        <Section background="gray" id="photos">
            <div class="mb-10 flex flex-col gap-4 border-b border-[var(--color-border)] pb-6 sm:flex-row sm:items-center sm:justify-between">
                <Link
                    href="/album"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--color-link)] transition-colors hover:text-[var(--color-action-hover)]"
                >
                    <Icon name="arrow-left" :size="16" />
                    Tous les albums
                </Link>

                <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-[var(--color-content-muted)]">
                    <span v-if="album.event_date" class="inline-flex items-center gap-1.5">
                        <Icon name="calendar" :size="15" />
                        <time :datetime="album.event_date">{{ formatDate(album.event_date) }}</time>
                    </span>
                    <span v-if="album.location" class="inline-flex items-center gap-1.5">
                        <Icon name="map-pin" :size="15" />
                        {{ album.location }}
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <Icon name="images" :size="15" />
                        {{ album.photo_count }}
                        {{ album.photo_count > 1 ? 'photos' : 'photo' }}
                    </span>
                </div>
            </div>

            <Stagger v-if="photos.data.length > 0" :stagger="0.04" :delay="0.05">
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <button
                        v-for="(photo, index) in photos.data"
                        :key="photo.id"
                        type="button"
                        class="group text-left focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-action)]"
                        @click="openLightbox(index)"
                    >
                        <div class="relative aspect-[4/3] overflow-hidden rounded-xl bg-[var(--color-surface-muted)]">
                            <img
                                v-if="photo.card_url"
                                :src="photo.card_url"
                                :alt="photo.alt"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                loading="lazy"
                                decoding="async"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center"
                            >
                                <Icon
                                    name="image"
                                    :size="40"
                                    class="text-[var(--color-content-placeholder)]"
                                />
                            </div>

                            <span class="absolute inset-0 bg-[var(--color-brand-navy)]/0 transition duration-300 group-hover:bg-[var(--color-brand-navy)]/25" />

                            <span class="absolute right-3 bottom-3 inline-flex items-center gap-1.5 rounded-full bg-black/60 px-2.5 py-1.5 text-xs font-medium text-white opacity-0 backdrop-blur-sm transition duration-200 group-hover:opacity-100 group-focus-visible:opacity-100">
                                <Icon name="maximize" :size="13" />
                                Agrandir
                            </span>
                        </div>

                        <p
                            v-if="photo.caption"
                            class="mt-3 line-clamp-2 text-sm font-medium text-[var(--color-content)]"
                        >
                            {{ photo.caption }}
                        </p>
                    </button>
                </div>
            </Stagger>

            <EmptyState
                v-else
                icon="images"
                title="Aucune photo publiée"
                description="Les photos de cet album seront publiées prochainement."
            />

            <nav
                v-if="photos.last_page > 1"
                class="mt-12 flex flex-wrap items-center justify-center gap-4"
                aria-label="Pagination des photos"
            >
                <Link
                    v-if="photos.prev_page_url"
                    :href="photos.prev_page_url"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-[var(--color-border-strong)] bg-[var(--color-surface)] px-4 py-2 text-sm font-medium text-[var(--color-content)] transition hover:border-[var(--color-action)] hover:text-[var(--color-link)]"
                >
                    <Icon name="chevron-left" :size="16" />
                    Précédent
                </Link>

                <span class="text-sm text-[var(--color-content-muted)]">
                    Page {{ photos.current_page }} sur {{ photos.last_page }}
                </span>

                <Link
                    v-if="photos.next_page_url"
                    :href="photos.next_page_url"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-[var(--color-border-strong)] bg-[var(--color-surface)] px-4 py-2 text-sm font-medium text-[var(--color-content)] transition hover:border-[var(--color-action)] hover:text-[var(--color-link)]"
                >
                    Suivant
                    <Icon name="chevron-right" :size="16" />
                </Link>
            </nav>
        </Section>

        <PhotoLightbox
            :photos="photos.data"
            :open="lightboxOpen"
            :start-index="activePhotoIndex"
            @close="lightboxOpen = false"
        />
    </PublicLayout>
</template>
