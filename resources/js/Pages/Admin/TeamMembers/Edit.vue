<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    member: {
        id: number;
        name: string;
        role: string;
        bio: string | null;
        email: string | null;
        phone: string | null;
        social_links: Array<{ name: string; url: string }>;
        is_active: boolean;
        sort_order: number;
        photo_url: string | null;
    };
}>();

const form = useForm({
    _method: 'put',
    name: props.member.name,
    role: props.member.role,
    bio: props.member.bio ?? '',
    email: props.member.email ?? '',
    phone: props.member.phone ?? '',
    is_active: props.member.is_active,
    sort_order: props.member.sort_order,
    photo: null as File | null,
    social_links: props.member.social_links.map((link) => ({ ...link })),
});

const addSocialLink = () => {
    form.social_links.push({ name: '', url: '' });
};

const removeSocialLink = (index: number) => {
    form.social_links.splice(index, 1);
};

const onPhotoChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    form.photo = target.files?.[0] ?? null;
};

const submit = () => {
    form.post(route('admin.team-members.update', props.member.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Modifier le membre" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                Modifier le membre
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="bg-[var(--color-surface)] p-6 shadow-sm sm:rounded-lg">
                    <form class="space-y-6" @submit.prevent="submit">
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <InputLabel for="name" value="Nom complet" />
                                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="role" value="Fonction / poste" />
                                <TextInput id="role" v-model="form.role" type="text" class="mt-1 block w-full" required />
                                <InputError class="mt-2" :message="form.errors.role" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="bio" value="Biographie courte" />
                            <textarea
                                id="bio"
                                v-model="form.bio"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                            />
                            <InputError class="mt-2" :message="form.errors.bio" />
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <InputLabel for="email" value="Email (optionnel)" />
                                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>
                            <div>
                                <InputLabel for="phone" value="Téléphone (optionnel)" />
                                <TextInput id="phone" v-model="form.phone" type="text" class="mt-1 block w-full" />
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <InputLabel value="Liens sociaux" />
                                <button type="button" class="text-sm text-indigo-600 hover:underline" @click="addSocialLink">
                                    + Ajouter un lien
                                </button>
                            </div>
                            <div class="mt-3 space-y-3">
                                <div
                                    v-for="(link, index) in form.social_links"
                                    :key="index"
                                    class="grid gap-3 rounded-md border border-[var(--color-border)] p-3 sm:grid-cols-[1fr_2fr_auto]"
                                >
                                    <div>
                                        <TextInput
                                            v-model="link.name"
                                            type="text"
                                            class="block w-full"
                                            placeholder="Nom (ex: LinkedIn)"
                                        />
                                        <InputError class="mt-1" :message="form.errors[`social_links.${index}.name`]" />
                                    </div>
                                    <div>
                                        <TextInput
                                            v-model="link.url"
                                            type="url"
                                            class="block w-full"
                                            placeholder="https://..."
                                        />
                                        <InputError class="mt-1" :message="form.errors[`social_links.${index}.url`]" />
                                    </div>
                                    <div class="flex items-start">
                                        <SecondaryButton type="button" @click="removeSocialLink(index)">
                                            Retirer
                                        </SecondaryButton>
                                    </div>
                                </div>
                                <p v-if="form.social_links.length === 0" class="text-sm text-[var(--color-content-muted)]">
                                    Aucun lien social ajouté.
                                </p>
                            </div>
                            <InputError class="mt-2" :message="form.errors.social_links" />
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <InputLabel for="sort_order" value="Ordre d’affichage" />
                                <TextInput id="sort_order" v-model.number="form.sort_order" type="number" min="0" class="mt-1 block w-full" />
                                <InputError class="mt-2" :message="form.errors.sort_order" />
                            </div>
                            <div class="flex items-end pb-2">
                                <label class="flex items-center">
                                    <Checkbox v-model:checked="form.is_active" name="is_active" />
                                    <span class="ms-2 text-sm text-[var(--color-content-muted)]">Actif (affiché sur le site)</span>
                                </label>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.is_active" />

                        <div>
                            <InputLabel for="photo" value="Photo (laisser vide pour conserver l’actuelle)" />
                            <div v-if="member.photo_url" class="mt-2 mb-3">
                                <img :src="member.photo_url" :alt="member.name" class="h-20 w-20 rounded-full object-cover" />
                            </div>
                            <input
                                id="photo"
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100"
                                @change="onPhotoChange"
                            />
                            <InputError class="mt-2" :message="form.errors.photo" />
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <Link :href="route('admin.team-members.index')">
                                <SecondaryButton type="button">Annuler</SecondaryButton>
                            </Link>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Enregistrer
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
