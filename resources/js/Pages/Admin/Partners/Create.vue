<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    description: '',
    website_url: '',
    is_active: true as boolean,
    sort_order: 0 as number,
    logo: null as File | null,
});

const onLogoChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    form.logo = target.files?.[0] ?? null;
};

const submit = () => {
    form.post(route('admin.partners.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Nouveau partenaire" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                Nouveau partenaire
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="bg-[var(--color-surface)] p-6 shadow-sm sm:rounded-lg">
                    <form class="space-y-6" @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Nom de l’organisation" />
                            <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="description" value="Description courte" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-[var(--color-border-strong)] shadow-sm focus:border-[var(--color-action)] focus:ring-[var(--color-action)]"
                            />
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <div>
                            <InputLabel for="website_url" value="Lien vers le site" />
                            <TextInput id="website_url" v-model="form.website_url" type="url" class="mt-1 block w-full" placeholder="https://..." />
                            <InputError class="mt-2" :message="form.errors.website_url" />
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
                            <InputLabel for="logo" value="Logo" />
                            <input
                                id="logo"
                                type="file"
                                accept="image/jpeg,image/png,image/webp,image/svg+xml"
                                class="mt-1 block w-full text-sm text-[var(--color-content-muted)] file:mr-4 file:rounded-md file:border-0 file:bg-[var(--color-action)]/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[var(--color-link)] hover:file:bg-[var(--color-action)]/15"
                                required
                                @change="onLogoChange"
                            />
                            <InputError class="mt-2" :message="form.errors.logo" />
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <Link :href="route('admin.partners.index')">
                                <SecondaryButton type="button">Annuler</SecondaryButton>
                            </Link>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Créer
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
