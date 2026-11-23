<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AlbumForm from '@/Pages/Admin/Albums/Partials/AlbumForm.vue'
import PhotoManager from '@/Pages/Admin/Albums/Partials/PhotoManager.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { Head, Link } from '@inertiajs/vue3'

interface AdminAlbum {
    id: number
    slug: string
    title: string
    description: string | null
    location: string | null
    event_date: string | null
    is_published: boolean
    sort_order: number
    cover_url: string | null
    photo_count: number
    published_photo_count: number
}

interface AdminAlbumPhoto {
    id: number
    caption: string | null
    alt_text: string | null
    is_published: boolean
    sort_order: number
    thumb_url: string | null
    is_cover: boolean
}

defineProps<{
    album: AdminAlbum
    photos: AdminAlbumPhoto[]
}>()
</script>

<template>
    <Head :title="`Album — ${album.title}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                        {{ album.title }}
                    </h2>
                    <p class="mt-1 text-sm text-[var(--color-content-muted)]">
                        {{ album.published_photo_count }} photo(s) publiée(s)
                        sur {{ album.photo_count }}.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a
                        v-if="album.is_published"
                        :href="route('album.show', album.slug)"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-[var(--color-border-strong)] bg-[var(--color-surface)] px-4 py-2 text-sm font-medium text-[var(--color-content)] transition hover:border-[var(--color-action)] hover:text-[var(--color-link)]"
                    >
                        Voir sur le site
                        <Icon name="arrow-right" :size="15" />
                    </a>

                    <Link
                        :href="route('admin.albums.index')"
                        class="inline-flex items-center gap-1.5 text-sm font-medium text-[var(--color-content-muted)] transition hover:text-[var(--color-link)]"
                    >
                        <Icon name="arrow-left" :size="15" />
                        Tous les albums
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
                <div class="bg-[var(--color-surface)] p-6 shadow-sm sm:rounded-lg">
                    <h3 class="mb-6 text-lg font-semibold text-[var(--color-content)]">
                        Informations de l’album
                    </h3>
                    <AlbumForm :album="album" />
                </div>

                <div class="bg-[var(--color-surface)] p-6 shadow-sm sm:rounded-lg">
                    <PhotoManager :album-id="album.id" :photos="photos" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
