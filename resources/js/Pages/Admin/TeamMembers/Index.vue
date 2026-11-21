<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, router } from '@inertiajs/vue3';

interface AdminTeamMember {
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
}

defineProps<{
    members: AdminTeamMember[];
}>();

const destroy = (member: AdminTeamMember) => {
    if (confirm(`Supprimer le membre « ${member.name} » ?`)) {
        router.delete(route('admin.team-members.destroy', member.id));
    }
};
</script>

<template>
    <Head title="Membres" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                    Membres de l’équipe
                </h2>
                <Link :href="route('admin.team-members.create')">
                    <PrimaryButton type="button">Nouveau membre</PrimaryButton>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Photo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Membre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Ordre</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[var(--color-border)] bg-[var(--color-surface)]">
                                <tr v-for="member in members" :key="member.id">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <img
                                            v-if="member.photo_url"
                                            :src="member.photo_url"
                                            :alt="member.name"
                                            class="h-12 w-12 rounded-full object-cover"
                                        />
                                        <div
                                            v-else
                                            class="flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-surface-muted)] text-sm font-semibold text-[var(--color-content-muted)]"
                                        >
                                            {{ member.name.slice(0, 1).toUpperCase() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-[var(--color-content)]">
                                        <div class="font-medium">{{ member.name }}</div>
                                        <div class="text-[var(--color-content-muted)]">{{ member.role }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-[var(--color-content-muted)]">
                                        <div v-if="member.email">{{ member.email }}</div>
                                        <div v-if="member.phone">{{ member.phone }}</div>
                                        <span v-if="!member.email && !member.phone">—</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <span
                                            v-if="member.is_active"
                                            class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700"
                                        >
                                            Actif
                                        </span>
                                        <span
                                            v-else
                                            class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700"
                                        >
                                            Inactif
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-content-muted)]">
                                        {{ member.sort_order }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <Link :href="route('admin.team-members.edit', member.id)">
                                                <SecondaryButton type="button">Modifier</SecondaryButton>
                                            </Link>
                                            <DangerButton type="button" @click="destroy(member)">
                                                Supprimer
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="members.length === 0">
                                    <td colspan="6" class="px-6 py-8 text-center text-sm text-[var(--color-content-muted)]">
                                        Aucun membre.
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
