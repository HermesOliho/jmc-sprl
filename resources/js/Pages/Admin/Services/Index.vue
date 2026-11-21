<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, router } from '@inertiajs/vue3';

interface AdminService {
    id: number;
    slug: string;
    title: string;
    description: string;
    icon: string;
    is_featured: boolean;
    home_sort_order: number;
    is_active: boolean;
    sort_order: number;
    cover_url: string | null;
}

defineProps<{
    services: AdminService[];
}>();

const destroy = (service: AdminService) => {
    if (confirm(`Supprimer le service « ${service.title} » ?`)) {
        router.delete(route('admin.services.destroy', service.id));
    }
};
</script>

<template>
    <Head title="Services" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                    Services
                </h2>
                <Link :href="route('admin.services.create')">
                    <PrimaryButton type="button">Nouveau service</PrimaryButton>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Visuel</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Service</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Ordres</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[var(--color-border)] bg-[var(--color-surface)]">
                                <tr v-for="service in services" :key="service.id">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <img
                                            v-if="service.cover_url"
                                            :src="service.cover_url"
                                            :alt="service.title"
                                            class="h-10 w-16 rounded object-cover"
                                        />
                                        <span v-else class="text-sm text-[var(--color-content-subtle)]">—</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-[var(--color-content)]">
                                        <div class="font-medium">{{ service.title }}</div>
                                        <div class="mt-1 font-mono text-xs text-[var(--color-content-muted)]">
                                            {{ service.slug }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <div class="flex flex-col items-start gap-1">
                                            <span
                                                v-if="service.is_active"
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
                                            <span
                                                v-if="service.is_featured"
                                                class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-700"
                                            >
                                                Accueil
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-content-muted)]">
                                        <div>Page : {{ service.sort_order }}</div>
                                        <div>Accueil : {{ service.home_sort_order }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <Link :href="route('admin.services.edit', service.id)">
                                                <SecondaryButton type="button">Modifier</SecondaryButton>
                                            </Link>
                                            <DangerButton type="button" @click="destroy(service)">
                                                Supprimer
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="services.length === 0">
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-[var(--color-content-muted)]">
                                        Aucun service.
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
