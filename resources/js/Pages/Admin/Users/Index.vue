<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, router } from '@inertiajs/vue3';

interface AdminUser {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    is_admin: boolean;
    created_at: string | null;
}

defineProps<{
    users: AdminUser[];
}>();

const destroy = (user: AdminUser) => {
    if (confirm(`Supprimer l'utilisateur « ${user.name} » ?`)) {
        router.delete(route('admin.users.destroy', user.id));
    }
};
</script>

<template>
    <Head title="Utilisateurs" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                    Utilisateurs
                </h2>
                <Link :href="route('admin.users.create')">
                    <PrimaryButton type="button">Nouvel utilisateur</PrimaryButton>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Rôle</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-[var(--color-content-muted)]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[var(--color-border)] bg-[var(--color-surface)]">
                                <tr v-for="user in users" :key="user.id">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-content)]">
                                        {{ user.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-[var(--color-content-muted)]">
                                        {{ user.email }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <span
                                            v-if="user.is_admin"
                                            class="inline-flex rounded-full bg-[var(--color-action)]/15 px-2 py-1 text-xs font-semibold text-[var(--color-link)]"
                                        >
                                            Admin
                                        </span>
                                        <span
                                            v-else
                                            class="inline-flex rounded-full bg-[var(--color-surface-muted)] px-2 py-1 text-xs font-semibold text-[var(--color-content-muted)]"
                                        >
                                            Utilisateur
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <Link :href="route('admin.users.edit', user.id)">
                                                <SecondaryButton type="button">Modifier</SecondaryButton>
                                            </Link>
                                            <DangerButton
                                                type="button"
                                                @click="destroy(user)"
                                            >
                                                Supprimer
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="users.length === 0">
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-[var(--color-content-muted)]">
                                        Aucun utilisateur.
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
