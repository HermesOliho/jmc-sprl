<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Icon from '@/Components/ui/icons/Icon.vue'
import { formatDate } from '@/utils'
import type { Album } from '@/types'

defineProps<{
    album: Album
}>()
</script>

<template>
    <Link
        :href="album.url"
        class="group flex h-full flex-col overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[var(--color-action)]/40 hover:shadow-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-action)]"
    >
        <div class="relative aspect-[3/2] overflow-hidden bg-[var(--color-surface-muted)]">
            <img
                v-if="album.cover_url"
                :src="album.cover_url"
                :alt="album.title"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                loading="lazy"
                decoding="async"
            />
            <div
                v-else
                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[var(--color-surface-muted)] to-[var(--color-surface-elevated)]"
            >
                <Icon
                    name="images"
                    :size="44"
                    class="text-[var(--color-content-placeholder)]"
                />
            </div>

            <span
                v-if="album.location"
                class="absolute top-3 left-3 inline-flex items-center gap-1.5 rounded-full bg-black/55 px-3 py-1.5 text-xs font-medium text-white backdrop-blur-sm"
            >
                <Icon name="map-pin" :size="13" />
                {{ album.location }}
            </span>
        </div>

        <div class="flex flex-1 flex-col p-5">
            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs font-medium uppercase tracking-wider text-[var(--color-content-subtle)]">
                <time v-if="album.event_date" :datetime="album.event_date">
                    {{ formatDate(album.event_date) }}
                </time>
                <span v-if="album.event_date" aria-hidden="true">•</span>
                <span>
                    {{ album.photo_count }}
                    {{ album.photo_count > 1 ? 'photos' : 'photo' }}
                </span>
            </div>

            <h3 class="mt-2 text-lg font-semibold text-[var(--color-content)] transition-colors group-hover:text-[var(--color-link)]">
                {{ album.title }}
            </h3>

            <p
                v-if="album.description"
                class="mt-2 line-clamp-2 text-sm leading-relaxed text-[var(--color-content-muted)]"
            >
                {{ album.description }}
            </p>

            <span class="mt-auto inline-flex items-center gap-1.5 pt-5 text-sm font-semibold text-[var(--color-link)]">
                Voir l’album
                <Icon name="arrow-right" :size="16" />
            </span>
        </div>
    </Link>
</template>
