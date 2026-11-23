<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DangerButton from '@/Components/DangerButton.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { formatDate } from '@/utils'
import { Head, Link, router } from '@inertiajs/vue3'

interface AdminAlbum {
    id: number
    slug: string
    title: string
    location: string | null
    event_date: string | null
    is_published: boolean
    sort_order: number
    cover_url: string | null
    photo_count: number
    published_photo_count: number
    created_at: string | null
}

defineProps<{
    albums: AdminAlbum[]
}>()

const destroy = (album: AdminAlbum): void => {
    if (confirm(`Supprimer l’album « ${album.title} » et toutes ses photos ?`)) {
        router.delete(route('admin.albums.destroy', album.id))
    }
}
</script>

<template>
    <Head title="Albums photo" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                        Albums photo
                    </h2>
                    <p class="mt-1 text-sm text-[var(--color-content-muted)]">
                        Gérez les albums et les photos publiés sur le site.
                    </p>
                </div>
                <Link :href="route('admin.albums.create')">
                    <PrimaryButton type="button">
                        <Icon name="images" :size="18" />
                        Nouvel album
                    </PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-[var(--color-surface)] shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[var(--color-border)]">
                            <thead class="bg-[var(--color-surface-muted)]">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Couverture</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Album</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Photos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Ordre</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[var(--color-border)] bg-[var(--color-surface)]">
                                <tr v-for="album in albums" :key="album.id">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <img
                                            v-if="album.cover_url"
                                            :src="album.cover_url"
                                            :alt="album.title"
                                            class="h-14 w-20 rounded-lg object-cover"
                                        />
                                        <div
                                            v-else
                                            class="flex h-14 w-20 items-center justify-center rounded-lg bg-[var(--color-surface-muted)]"
                                        >
                                            <Icon name="images" :size="22" class="text-[var(--color-content-placeholder)]" />
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-[var(--color-content)]">
                                        <div class="font-medium">{{ album.title }}</div>
                                        <div v-if="album.location" class="mt-1 text-xs text-[var(--color-content-muted)]">
                                            {{ album.location }}
                                        </div>
                                        <a
                                            v-if="album.is_published"
                                            :href="route('album.show', album.slug)"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="mt-1 inline-flex items-center gap-1 text-xs text-[var(--color-link)] hover:underline"
                                        >
                                            Voir sur le site
                                            <Icon name="arrow-right" :size="12" />
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-content-muted)]">
                                        {{ album.event_date ? formatDate(album.event_date) : '—' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-content-muted)]">
                                        {{ album.published_photo_count }}
                                        <span class="text-[var(--color-content-placeholder)]">/ {{ album.photo_count }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <span
                                            v-if="album.is_published"
                                            class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700"
                                        >
                                            Publié
                                        </span>
                                        <span
                                            v-else
                                            class="inline-flex rounded-full bg-[var(--color-surface-muted)] px-2 py-1 text-xs font-semibold text-[var(--color-content-muted)]"
                                        >
                                            Brouillon
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-content-muted)]">
                                        {{ album.sort_order }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <Link :href="route('admin.albums.edit', album.id)">
                                                <SecondaryButton type="button">Gérer</SecondaryButton>
                                            </Link>
                                            <DangerButton type="button" @click="destroy(album)">
                                                Supprimer
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="albums.length === 0">
                                    <td colspan="7" class="px-6 py-10 text-center text-sm text-[var(--color-content-muted)]">
                                        Aucun album pour le moment.
                                        <Link
                                            :href="route('admin.albums.create')"
                                            class="ms-1 font-medium text-[var(--color-link)] hover:underline"
                                        >
                                            Créer le premier album
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
