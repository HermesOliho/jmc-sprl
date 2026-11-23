<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { Link, useForm } from '@inertiajs/vue3'

interface EditableAlbum {
    id: number
    slug: string
    title: string
    description: string | null
    location: string | null
    event_date: string | null
    is_published: boolean
    sort_order: number
    cover_url: string | null
}

const props = defineProps<{
    album?: EditableAlbum
}>()

const form = useForm({
    title: props.album?.title ?? '',
    slug: props.album?.slug ?? '',
    description: props.album?.description ?? '',
    location: props.album?.location ?? '',
    event_date: props.album?.event_date ?? '',
    is_published: props.album?.is_published ?? false,
    sort_order: props.album?.sort_order ?? 0,
})

const submit = (): void => {
    if (props.album) {
        form.put(route('admin.albums.update', props.album.id))
        return
    }

    form.post(route('admin.albums.store'))
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="submit">
        <div>
            <InputLabel for="title" value="Titre de l’album" />
            <TextInput
                id="title"
                v-model="form.title"
                type="text"
                class="mt-1 block w-full"
                required
                autofocus
                placeholder="Ex. Chantier de Durba — mai 2026"
            />
            <InputError class="mt-2" :message="form.errors.title" />
        </div>

        <div>
            <InputLabel for="slug" value="Slug (facultatif)" />
            <TextInput
                id="slug"
                v-model="form.slug"
                type="text"
                class="mt-1 block w-full"
                placeholder="genere-automatiquement-depuis-le-titre"
            />
            <p class="mt-1 text-xs text-[var(--color-content-subtle)]">
                Laissez vide pour générer automatiquement l’adresse de l’album.
            </p>
            <InputError class="mt-2" :message="form.errors.slug" />
        </div>

        <div>
            <InputLabel for="description" value="Description" />
            <textarea
                id="description"
                v-model="form.description"
                rows="4"
                class="mt-1 block w-full rounded-md border-[var(--color-border-strong)] shadow-sm focus:border-[var(--color-action)] focus:ring-[var(--color-action)]"
                placeholder="Quelques lignes pour présenter cet album."
            />
            <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <InputLabel for="location" value="Lieu" />
                <TextInput
                    id="location"
                    v-model="form.location"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Durba, Haut-Uélé"
                />
                <InputError class="mt-2" :message="form.errors.location" />
            </div>

            <div>
                <InputLabel for="event_date" value="Date de l’événement" />
                <TextInput
                    id="event_date"
                    v-model="form.event_date"
                    type="date"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.event_date" />
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <InputLabel for="sort_order" value="Ordre d’affichage" />
                <TextInput
                    id="sort_order"
                    v-model.number="form.sort_order"
                    type="number"
                    min="0"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.sort_order" />
            </div>

            <div class="flex items-end pb-2">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.is_published" name="is_published" />
                    <span class="ms-2 text-sm text-[var(--color-content-muted)]">
                        Publier l’album sur le site
                    </span>
                </label>
            </div>
        </div>
        <InputError class="mt-2" :message="form.errors.is_published" />

        <div
            v-if="album?.cover_url"
            class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface-muted)] p-4"
        >
            <p class="mb-3 flex items-center gap-2 text-sm font-medium text-[var(--color-content)]">
                <Icon name="image" :size="16" />
                Couverture actuelle
            </p>
            <img
                :src="album.cover_url"
                :alt="album.title"
                class="h-36 w-full max-w-sm rounded-lg object-cover"
            />
            <p class="mt-2 text-xs text-[var(--color-content-subtle)]">
                La couverture se définit depuis la liste des photos.
            </p>
        </div>

        <div class="flex flex-wrap items-center justify-end gap-3">
            <Link :href="route('admin.albums.index')">
                <SecondaryButton type="button">Annuler</SecondaryButton>
            </Link>
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                {{ album ? 'Enregistrer les modifications' : 'Créer l’album' }}
            </PrimaryButton>
        </div>
    </form>
</template>
