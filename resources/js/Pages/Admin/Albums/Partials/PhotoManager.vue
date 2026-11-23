<script setup lang="ts">
import { computed, onBeforeUnmount, ref } from 'vue'
import EmptyState from '@/Components/ui/feedback/EmptyState.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import PhotoItem from '@/Pages/Admin/Albums/Partials/PhotoItem.vue'
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
    photos: AdminAlbumPhoto[]
}>()

interface Preview {
    url: string
    name: string
}

const fileInput = ref<HTMLInputElement | null>(null)
const previews = ref<Preview[]>([])
const dragActive = ref(false)
const selectionError = ref<string | null>(null)
const reordering = ref(false)

const uploadForm = useForm({
    photos: [] as File[],
})

const uploadErrors = computed<string[]>(() => Object.values(uploadForm.errors))

function clearPreviews(): void {
    previews.value.forEach((preview) => URL.revokeObjectURL(preview.url))
    previews.value = []
}

function setFiles(fileList: FileList | null): void {
    selectionError.value = null
    clearPreviews()

    if (!fileList) {
        uploadForm.photos = []

        return
    }

    const images = Array.from(fileList).filter((file) => file.type.startsWith('image/'))

    if (images.length === 0) {
        selectionError.value = 'Veuillez sélectionner des images JPG, PNG ou WebP.'
        uploadForm.photos = []

        return
    }

    if (images.length > 10) {
        selectionError.value = 'Vous pouvez ajouter au maximum 10 photos à la fois.'
    }

    const selected = images.slice(0, 10)
    uploadForm.photos = selected
    previews.value = selected.map((file) => ({
        url: URL.createObjectURL(file),
        name: file.name,
    }))
}

function handleFileChange(event: Event): void {
    const target = event.target as HTMLInputElement
    setFiles(target.files)
}

function handleDrop(event: DragEvent): void {
    dragActive.value = false
    setFiles(event.dataTransfer?.files ?? null)
}

function resetSelection(): void {
    clearPreviews()
    uploadForm.photos = []
    uploadForm.clearErrors()

    if (fileInput.value) {
        fileInput.value.value = ''
    }
}

function upload(): void {
    uploadForm.post(route('admin.albums.photos.store', props.albumId), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => resetSelection(),
    })
}

function move(index: number, direction: -1 | 1): void {
    const target = index + direction

    if (reordering.value || target < 0 || target >= props.photos.length) {
        return
    }

    const ids = props.photos.map((photo) => photo.id)
    const current = ids[index]
    ids[index] = ids[target]
    ids[target] = current

    router.patch(
        route('admin.albums.photos.reorder', props.albumId),
        { photo_ids: ids },
        {
            preserveScroll: true,
            onStart: () => {
                reordering.value = true
            },
            onFinish: () => {
                reordering.value = false
            },
        },
    )
}

onBeforeUnmount(clearPreviews)
</script>

<template>
    <div class="space-y-6">
        <div>
            <h3 class="text-lg font-semibold text-[var(--color-content)]">
                Photos de l’album
            </h3>
            <p class="mt-1 text-sm text-[var(--color-content-muted)]">
                Ajoutez jusqu’à 10 photos à la fois (JPG, PNG ou WebP, 10 Mo maximum par photo).
                Les nouvelles photos sont publiées automatiquement.
            </p>
        </div>

        <label
            class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed px-6 py-10 text-center transition"
            :class="dragActive
                ? 'border-[var(--color-action)] bg-[var(--color-action)]/5'
                : 'border-[var(--color-border-strong)] bg-[var(--color-surface-muted)]/60 hover:border-[var(--color-action)]/60 hover:bg-[var(--color-action)]/5'"
            @dragover.prevent="dragActive = true"
            @dragleave.prevent="dragActive = false"
            @drop.prevent="handleDrop"
        >
            <input
                ref="fileInput"
                type="file"
                multiple
                accept="image/jpeg,image/png,image/webp"
                class="sr-only"
                @change="handleFileChange"
            />
            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-action)]/10">
                <Icon name="upload" :size="24" class="text-[var(--color-link)]" />
            </span>
            <span class="mt-3 text-sm font-semibold text-[var(--color-content)]">
                Glissez vos photos ici ou cliquez pour parcourir
            </span>
            <span class="mt-1 text-xs text-[var(--color-content-subtle)]">
                Sélection multiple autorisée
            </span>
        </label>

        <p v-if="selectionError" class="text-sm text-[var(--color-error)]">
            {{ selectionError }}
        </p>

        <div v-if="previews.length > 0" class="space-y-4">
            <div class="grid grid-cols-3 gap-3 sm:grid-cols-5">
                <div
                    v-for="preview in previews"
                    :key="preview.url"
                    class="overflow-hidden rounded-lg border border-[var(--color-border)] bg-[var(--color-surface-muted)]"
                >
                    <img
                        :src="preview.url"
                        :alt="preview.name"
                        class="aspect-square w-full object-cover"
                    />
                </div>
            </div>

            <p
                v-for="message in uploadErrors"
                :key="message"
                class="text-sm text-[var(--color-error)]"
            >
                {{ message }}
            </p>

            <div class="flex flex-wrap items-center gap-3">
                <PrimaryButton
                    type="button"
                    :disabled="uploadForm.processing"
                    :loading="uploadForm.processing"
                    @click="upload"
                >
                    Publier {{ previews.length }}
                    {{ previews.length > 1 ? 'photos' : 'photo' }}
                </PrimaryButton>
                <button
                    type="button"
                    class="text-sm font-medium text-[var(--color-content-muted)] transition hover:text-[var(--color-content)]"
                    @click="resetSelection"
                >
                    Annuler la sélection
                </button>
            </div>
        </div>

        <div v-if="photos.length > 0" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <PhotoItem
                v-for="(photo, index) in photos"
                :key="photo.id"
                :album-id="albumId"
                :photo="photo"
                :can-move-up="index > 0"
                :can-move-down="index < photos.length - 1"
                @move-up="move(index, -1)"
                @move-down="move(index, 1)"
            />
        </div>

        <EmptyState
            v-else
            icon="images"
            title="Aucune photo dans cet album"
            description="Utilisez la zone ci-dessus pour ajouter les premières photos."
        />
    </div>
</template>
