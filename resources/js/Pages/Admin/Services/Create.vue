<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps<{
    iconOptions: string[];
}>();

const form = useForm({
    title: '',
    slug: '',
    description: '',
    icon: 'building2',
    deliverables: [] as string[],
    newDeliverable: '',
    benefits: [] as string[],
    newBenefit: '',
    is_active: true as boolean,
    is_featured: false as boolean,
    sort_order: 0 as number,
    home_sort_order: 0 as number,
    cover: null as File | null,
    image_alt: '',
    image_position: 'center',
});

const addDeliverable = () => {
    const value = form.newDeliverable.trim();

    if (value) {
        form.deliverables.push(value);
        form.newDeliverable = '';
    }
};

const removeDeliverable = (index: number) => {
    form.deliverables.splice(index, 1);
};

const addBenefit = () => {
    const value = form.newBenefit.trim();

    if (value) {
        form.benefits.push(value);
        form.newBenefit = '';
    }
};

const removeBenefit = (index: number) => {
    form.benefits.splice(index, 1);
};

const onCoverChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    form.cover = target.files?.[0] ?? null;
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        newDeliverable: undefined,
        newBenefit: undefined,
    })).post(route('admin.services.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Nouveau service" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                Nouveau service
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="bg-[var(--color-surface)] p-6 shadow-sm sm:rounded-lg">
                    <form class="space-y-6" @submit.prevent="submit">
                        <div>
                            <InputLabel for="title" value="Titre" />
                            <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" required autofocus />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <InputLabel for="slug" value="Slug (optionnel, généré depuis le titre)" />
                                <TextInput id="slug" v-model="form.slug" type="text" class="mt-1 block w-full" placeholder="mon-service" />
                                <InputError class="mt-2" :message="form.errors.slug" />
                            </div>
                            <div>
                                <InputLabel for="icon" value="Icône" />
                                <select
                                    id="icon"
                                    v-model="form.icon"
                                    class="mt-1 block w-full rounded-md border-[var(--color-border-strong)] bg-[var(--color-surface)] shadow-sm focus:border-[var(--color-action)] focus:ring-[var(--color-action)]"
                                    required
                                >
                                    <option v-for="icon in iconOptions" :key="icon" :value="icon">
                                        {{ icon }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.icon" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-[var(--color-border-strong)] bg-[var(--color-surface)] shadow-sm focus:border-[var(--color-action)] focus:ring-[var(--color-action)]"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <InputLabel value="Prestations" />
                            </div>
                            <div class="mt-3 flex gap-2">
                                <TextInput v-model="form.newDeliverable" type="text" class="block w-full" placeholder="Ajouter une prestation…" @keyup.enter.prevent="addDeliverable" />
                                <SecondaryButton type="button" @click="addDeliverable">Ajouter</SecondaryButton>
                            </div>
                            <ul v-if="form.deliverables.length > 0" class="mt-3 space-y-2">
                                <li
                                    v-for="(item, index) in form.deliverables"
                                    :key="`${item}-${index}`"
                                    class="flex items-center justify-between gap-3 rounded-md border border-[var(--color-border)] px-3 py-2 text-sm"
                                >
                                    <span>{{ item }}</span>
                                    <button type="button" class="text-sm text-red-600 hover:underline" @click="removeDeliverable(index)">
                                        Retirer
                                    </button>
                                </li>
                            </ul>
                            <InputError class="mt-2" :message="form.errors.deliverables" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <InputLabel value="Avantages" />
                            </div>
                            <div class="mt-3 flex gap-2">
                                <TextInput v-model="form.newBenefit" type="text" class="block w-full" placeholder="Ajouter un avantage…" @keyup.enter.prevent="addBenefit" />
                                <SecondaryButton type="button" @click="addBenefit">Ajouter</SecondaryButton>
                            </div>
                            <ul v-if="form.benefits.length > 0" class="mt-3 space-y-2">
                                <li
                                    v-for="(item, index) in form.benefits"
                                    :key="`${item}-${index}`"
                                    class="flex items-center justify-between gap-3 rounded-md border border-[var(--color-border)] px-3 py-2 text-sm"
                                >
                                    <span>{{ item }}</span>
                                    <button type="button" class="text-sm text-red-600 hover:underline" @click="removeBenefit(index)">
                                        Retirer
                                    </button>
                                </li>
                            </ul>
                            <InputError class="mt-2" :message="form.errors.benefits" />
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <InputLabel for="sort_order" value="Ordre sur la page Services" />
                                <TextInput id="sort_order" v-model.number="form.sort_order" type="number" min="0" class="mt-1 block w-full" />
                                <InputError class="mt-2" :message="form.errors.sort_order" />
                            </div>
                            <div>
                                <InputLabel for="home_sort_order" value="Ordre sur l’accueil" />
                                <TextInput id="home_sort_order" v-model.number="form.home_sort_order" type="number" min="0" class="mt-1 block w-full" />
                                <InputError class="mt-2" :message="form.errors.home_sort_order" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-8">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.is_active" name="is_active" />
                                <span class="ms-2 text-sm text-[var(--color-content-muted)]">Actif (affiché sur le site)</span>
                            </label>
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.is_featured" name="is_featured" />
                                <span class="ms-2 text-sm text-[var(--color-content-muted)]">Mis en avant sur l’accueil</span>
                            </label>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <InputLabel for="cover" value="Image de couverture (JPG, PNG, WebP)" />
                                <input
                                    id="cover"
                                    type="file"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="mt-1 block w-full text-sm text-[var(--color-content-muted)] file:mr-4 file:rounded-md file:border-0 file:bg-[var(--color-action)]/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[var(--color-link)] hover:file:bg-[var(--color-action)]/15"
                                    @change="onCoverChange"
                                />
                                <InputError class="mt-2" :message="form.errors.cover" />
                            </div>
                            <div>
                                <InputLabel for="image_position" value="Cadrage de l’image" />
                                <select
                                    id="image_position"
                                    v-model="form.image_position"
                                    class="mt-1 block w-full rounded-md border-[var(--color-border-strong)] bg-[var(--color-surface)] shadow-sm focus:border-[var(--color-action)] focus:ring-[var(--color-action)]"
                                >
                                    <option value="center">Centre</option>
                                    <option value="top">Haut</option>
                                    <option value="bottom">Bas</option>
                                    <option value="left">Gauche</option>
                                    <option value="right">Droite</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.image_position" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="image_alt" value="Texte alternatif de l’image (optionnel)" />
                            <TextInput id="image_alt" v-model="form.image_alt" type="text" class="mt-1 block w-full" placeholder="Description de l’image" />
                            <InputError class="mt-2" :message="form.errors.image_alt" />
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <Link :href="route('admin.services.index')">
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
