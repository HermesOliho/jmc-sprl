<script setup lang="ts">
import { watch } from 'vue'
import DangerButton from '@/Components/DangerButton.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import TextInput from '@/Components/TextInput.vue'
import { router, useForm } from '@inertiajs/vue3'

interface AdminAlbumPhoto {
    id: number
    caption: string | null
    alt_text: string | null
    is_published: boolean
    sort_order: number
    thumb_url: string | null
    is_cover: boolean
}

const props = defineProps<{
    albumId: number
    photo: AdminAlbumPhoto
    canMoveUp: boolean
    canMoveDown: boolean
}>()

const emit = defineEmits<{
    'move-up': []
    'move-down': []
}>()

const form = useForm({
    caption: props.photo.caption ?? '',
    alt_text: props.photo.alt_text ?? '',
})

watch(
    () => props.photo,
    (photo) => {
        form.caption = photo.caption ?? ''
        form.alt_text = photo.alt_text ?? ''
    },
    { deep: true },
)

const updateRoute = (): string =>
    route('admin.albums.photos.update', {
        album: props.albumId,
        albumPhoto: props.photo.id,
    })

const destroyRoute = (): string =>
    route('admin.albums.photos.destroy', {
        album: props.albumId,
        albumPhoto: props.photo.id,
    })

const save = (): void => {
    form.patch(updateRoute(), {
        preserveScroll: true,
        onSuccess: () => form.clearErrors(),
    })
}

const setCover = (): void => {
    router.patch(updateRoute(), { is_cover: true }, { preserveScroll: true })
}

const togglePublished = (): void => {
    router.patch(
        updateRoute(),
        { is_published: !props.photo.is_published },
        { preserveScroll: true },
    )
}

const destroy = (): void => {
    if (confirm('Supprimer cette photo ?')) {
        router.delete(destroyRoute(), { preserveScroll: true })
    }
}
</script>

<template>
    <div class="overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm">
        <div class="relative aspect-[4/3] bg-[var(--color-surface-muted)]">
            <img
                v-if="photo.thumb_url"
                :src="photo.thumb_url"
                :alt="photo.alt_text || photo.caption || 'Photo de l’album'"
                class="h-full w-full object-cover"
                loading="lazy"
            />
            <div
                v-else
                class="flex h-full w-full items-center justify-center"
            >
                <Icon name="image" :size="32" class="text-[var(--color-content-placeholder)]" />
            </div>

            <span
                v-if="photo.is_cover"
                class="absolute top-2 left-2 inline-flex items-center gap-1 rounded-full bg-[var(--color-action)] px-2.5 py-1 text-xs font-semibold text-white shadow-sm"
            >
                <Icon name="star" :size="12" />
                Couverture
            </span>

            <span
                v-if="!photo.is_published"
                class="absolute top-2 right-2 rounded-full bg-black/65 px-2.5 py-1 text-xs font-semibold text-white"
            >
                Masquée
            </span>
        </div>

        <div class="space-y-3 p-4">
            <div>
                <InputLabel :for="`caption-${photo.id}`" value="Légende" />
                <TextInput
                    :id="`caption-${photo.id}`"
                    v-model="form.caption"
                    type="text"
                    class="mt-1 block w-full text-sm"
                    placeholder="Décrire la photo"
                />
                <InputError class="mt-1" :message="form.errors.caption" />
            </div>

            <div>
                <InputLabel :for="`alt-${photo.id}`" value="Texte alternatif" />
                <TextInput
                    :id="`alt-${photo.id}`"
                    v-model="form.alt_text"
                    type="text"
                    class="mt-1 block w-full text-sm"
                    placeholder="Description pour l’accessibilité"
                />
                <InputError class="mt-1" :message="form.errors.alt_text" />
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <PrimaryButton
                    type="button"
                    size="sm"
                    :disabled="form.processing"
                    @click="save"
                >
                    Enregistrer
                </PrimaryButton>

                <SecondaryButton
                    v-if="!photo.is_cover"
                    type="button"
                    size="sm"
                    @click="setCover"
                >
                    <Icon name="star" :size="14" />
                    Couverture
                </SecondaryButton>

                <SecondaryButton type="button" size="sm" @click="togglePublished">
                    <Icon :name="photo.is_published ? 'x' : 'circle-check'" :size="14" />
                    {{ photo.is_published ? 'Masquer' : 'Publier' }}
                </SecondaryButton>

                <div class="ms-auto flex items-center gap-1">
                    <button
                        type="button"
                        class="rounded-lg p-2 text-[var(--color-content-muted)] transition hover:bg-[var(--color-surface-elevated)] hover:text-[var(--color-content)] disabled:cursor-not-allowed disabled:opacity-30"
                        :disabled="!canMoveUp"
                        aria-label="Déplacer la photo vers le haut"
                        @click="emit('move-up')"
                    >
                        <Icon name="arrow-up" :size="16" />
                    </button>
                    <button
                        type="button"
                        class="rounded-lg p-2 text-[var(--color-content-muted)] transition hover:bg-[var(--color-surface-elevated)] hover:text-[var(--color-content)] disabled:cursor-not-allowed disabled:opacity-30"
                        :disabled="!canMoveDown"
                        aria-label="Déplacer la photo vers le bas"
                        @click="emit('move-down')"
                    >
                        <Icon name="arrow-up" :size="16" class="rotate-180" />
                    </button>
                    <DangerButton type="button" @click="destroy">
                        <Icon name="trash" :size="14" />
                        <span class="sr-only">Supprimer</span>
                    </DangerButton>
                </div>
            </div>
        </div>
    </div>
</template>
