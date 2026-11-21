<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, router } from '@inertiajs/vue3';

interface AdminPartner {
    id: number;
    name: string;
    description: string | null;
    website_url: string | null;
    is_active: boolean;
    sort_order: number;
    logo_url: string | null;
}

defineProps<{
    partners: AdminPartner[];
}>();

const destroy = (partner: AdminPartner) => {
    if (confirm(`Supprimer le partenaire « ${partner.name} » ?`)) {
        router.delete(route('admin.partners.destroy', partner.id));
    }
};
</script>

<template>
    <Head title="Partenaires" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                    Partenaires
                </h2>
                <Link :href="route('admin.partners.create')">
                    <PrimaryButton type="button">Nouveau partenaire</PrimaryButton>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Logo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Lien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Ordre</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[var(--color-border)] bg-[var(--color-surface)]">
                                <tr v-for="partner in partners" :key="partner.id">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <img
                                            v-if="partner.logo_url"
                                            :src="partner.logo_url"
                                            :alt="partner.name"
                                            class="h-10 w-auto max-w-[120px] object-contain"
                                        />
                                        <span v-else class="text-sm text-[var(--color-content-subtle)]">—</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-[var(--color-content)]">
                                        <div class="font-medium">{{ partner.name }}</div>
                                        <div v-if="partner.description" class="mt-1 max-w-md truncate text-xs text-[var(--color-content-muted)]">
                                            {{ partner.description }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-[var(--color-content-muted)]">
                                        <a
                                            v-if="partner.website_url"
                                            :href="partner.website_url"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-[var(--color-link)] hover:underline"
                                        >
                                            {{ partner.website_url }}
                                        </a>
                                        <span v-else>—</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <span
                                            v-if="partner.is_active"
                                            class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700"
                                        >
                                            Actif
                                        </span>
                                        <span
                                            v-else
                                            class="inline-flex rounded-full bg-[var(--color-surface-muted)] px-2 py-1 text-xs font-semibold text-[var(--color-content-muted)]"
                                        >
                                            Inactif
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-content-muted)]">
                                        {{ partner.sort_order }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <Link :href="route('admin.partners.edit', partner.id)">
                                                <SecondaryButton type="button">Modifier</SecondaryButton>
                                            </Link>
                                            <DangerButton type="button" @click="destroy(partner)">
                                                Supprimer
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="partners.length === 0">
                                    <td colspan="6" class="px-6 py-8 text-center text-sm text-[var(--color-content-muted)]">
                                        Aucun partenaire.
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
