<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    stats: {
        users: number;
        partners: number;
        active_partners: number;
    };
}>();
</script>

<template>
    <Head title="Administration" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                Administration
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="overflow-hidden bg-[var(--color-surface)] p-6 shadow-sm sm:rounded-lg">
                        <div class="text-sm text-[var(--color-content-muted)]">Utilisateurs</div>
                        <div class="mt-2 text-3xl font-semibold text-[var(--color-content)]">
                            {{ stats.users }}
                        </div>
                    </div>
                    <div class="overflow-hidden bg-[var(--color-surface)] p-6 shadow-sm sm:rounded-lg">
                        <div class="text-sm text-[var(--color-content-muted)]">Partenaires</div>
                        <div class="mt-2 text-3xl font-semibold text-[var(--color-content)]">
                            {{ stats.partners }}
                        </div>
                    </div>
                    <div class="overflow-hidden bg-[var(--color-surface)] p-6 shadow-sm sm:rounded-lg">
                        <div class="text-sm text-[var(--color-content-muted)]">Partenaires actifs</div>
                        <div class="mt-2 text-3xl font-semibold text-[var(--color-content)]">
                            {{ stats.active_partners }}
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <Link
                        :href="route('admin.users.index')"
                        class="block overflow-hidden bg-[var(--color-surface)] p-6 shadow-sm transition hover:shadow-md sm:rounded-lg"
                    >
                        <h3 class="text-lg font-medium text-[var(--color-content)]">
                            Gestion des utilisateurs
                        </h3>
                        <p class="mt-2 text-sm text-[var(--color-content-muted)]">
                            Créer, modifier et supprimer les comptes utilisateurs.
                        </p>
                    </Link>
                    <Link
                        :href="route('admin.partners.index')"
                        class="block overflow-hidden bg-[var(--color-surface)] p-6 shadow-sm transition hover:shadow-md sm:rounded-lg"
                    >
                        <h3 class="text-lg font-medium text-[var(--color-content)]">
                            Gestion des partenaires
                        </h3>
                        <p class="mt-2 text-sm text-[var(--color-content-muted)]">
                            Gérer les partenaires affichés dans le carousel de la page d’accueil.
                        </p>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
